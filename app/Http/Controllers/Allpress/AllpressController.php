<?php

namespace App\Http\Controllers\Allpress;

use App\Http\Controllers\Controller;
use App\Model\AllpressCafe;
use Illuminate\Http\Request;

class AllpressController extends Controller
{
    //https://nz.allpressespresso.com/api/cafes
    protected function importCafes()
    {
        //var_dump(file_get_contents('https://nz.allpressespresso.com/api/cafes'));die;

        $path = storage_path() . "/imports/allpress.json";
        $json = file_get_contents($path, true);
        $json = json_decode($json);

        foreach ($json as $restaurant) {

            $cafe = AllpressCafe::where('service', 'zomato')->where('id', $restaurant->id)->first();

            // just update a couple things
            if (!empty($cafe)) {
                continue;
            }

            $cafe = new AllpressCafe();

            $cafe->name = $restaurant->title ?? '';
            $cafe->id = $restaurant->id ?? '';
            $cafe->city = $restaurant->town_city->name ?? '';
            $cafe->country = $restaurant->region->name ?? '';
            $cafe->address = $restaurant->location->address ?? '';
            $cafe->latitude = $restaurant->location->lat ?? '';
            $cafe->longitude = $restaurant->location->lng ?? '';
            $cafe->save();

        }
    }
}
