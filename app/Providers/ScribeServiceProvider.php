<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use App\Models\User;
use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Symfony\Component\HttpFoundation\Request;
use Knuckles\Scribe\Scribe;
class ScribeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (class_exists(\Knuckles\Scribe\Scribe::class)) {
            Scribe::beforeResponseCall(function (Request $request, ExtractedEndpointData $endpointData) {
                $user = User::first();
                if ($user) {
                    // delete previous token
                    $user->tokens()->where('name', 'scribe-token')->delete();
                    $token = $user->createToken('scribe-token')->plainTextToken;
                }
                $request->headers->add(["Authorization" => "Bearer $token"]);
            });
        }            
    }
}