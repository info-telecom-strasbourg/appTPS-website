<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;

class CTSController extends Controller
{
    public function index(){
        if (Cache::has('trams')) {
            $trams = Cache::get('trams');
        } else {
            $stopCode = "75"; // Stop code for the tram stop "Campus d'Illkirch"
            $response = Http::withBasicAuth(env('CTS_API_KEY'),'')->get('https://api.cts-strasbourg.eu/v1/siri/2.0/stop-monitoring', [
                'MonitoringRef' => $stopCode
            ]);

            $response = $response->json();

            $tmp_json = json_decode(json_encode($response), true);
            $keysToRemove = [
                'ServiceDelivery.RequestMessageRef',
                'ServiceDelivery.ResponseTimestamp',
                'ServiceDelivery.StopMonitoringDelivery.0.version',
                'ServiceDelivery.StopMonitoringDelivery.0.ShortestPossibleCycle',
            ];
            
            foreach ($keysToRemove as $keyToRemove) {
                Arr::forget($tmp_json, $keyToRemove);
            }
            
            $keysToRemove = [
                'MonitoringRef',
                'MonitoredVehicleJourney.FramedVehicleJourneyRef',
                'MonitoredVehicleJourney.PublishedLineName',
                'MonitoredVehicleJourney.DestinationShortName',
                'MonitoredVehicleJourney.Via',
                'MonitoredVehicleJourney.MonitoredCall.ExpectedArrivalTime',
            ];
            for ($i = 0; $i < count($tmp_json['ServiceDelivery']['StopMonitoringDelivery'][0]['MonitoredStopVisit']); $i++) {
                foreach ($keysToRemove as $keyToRemove) {
                    Arr::forget($tmp_json['ServiceDelivery']['StopMonitoringDelivery'][0]['MonitoredStopVisit'][$i], $keyToRemove);
                }
            }

            $trams = $tmp_json['ServiceDelivery']['StopMonitoringDelivery'][0];

            $validUntil = $trams['ValidUntil']; 
            $validUntilTime = strtotime($validUntil); // Convert the validUntil value to a timestamp
            $currentTime = time(); // Get the current time as a timestamp
            $secondsUntilValidUntil = $validUntilTime - $currentTime; // Calculate the number of seconds until the validUntil time

            if ($secondsUntilValidUntil > 0) {
                Cache::put('trams', $trams, $secondsUntilValidUntil);
            }
        }

        return $trams;
        // return response()->json([
        //     'message' => 'Trams retrieved',
        //     'data' => $trams
        // ], 201);
    }
}
