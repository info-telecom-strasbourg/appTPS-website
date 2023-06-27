<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Goutte\Client;

class CrousController extends Controller
{
    public function index(){
        $client = new Client();

        $months = array(
            'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
            'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
        );

        $crawler = $client->request('GET', "https://www.crous-strasbourg.fr/restaurant/resto-u-illkirch/");

        $menuContainers = $crawler->filter('.menu');

        $menuContainers->each(function ($menuContainer) use ($months){

            preg_match("/(\d{1,2}) (\w+) (\d{4})/",
                $menuContainer->filter('.menu_date_title')->text(),
                $matches);

            $day = intval($matches[1]);
            $month = array_search($matches[2], $months) + 1;
            $year = intval($matches[3]);

            $date = date("Y-m-d", strtotime("$year-$month-$day"));

            $meals = $menuContainer->filter('.meal_foodies');

            $meals->each(function ($meal){

                dd($meal->html(),$meal->filter('li')->html());
            });
            dd($date);
        });

        dd($crawler->filter('.menu')->text());
    }
}
