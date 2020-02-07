<?php

namespace App\Http\Controllers\Zomato;

use App\Http\Controllers\Controller;
use App\Model\Cafe;
use App\Model\Zomato\City;
use App\Model\Zomato\Cuisine;
use App\Model\ZomatoCafe;
use Illuminate\Http\Request;
use Zomato\Api\Zomato;

class ZomatoController extends Controller
{
    protected $zomato = null;
    const COUNT = 20;

    public function __construct()
    {
        $this->zomato = new Zomato('32008c6bdc69e341b87764f0c397a8d7');
    }

    protected function getCities()
    {
        $cities = [
            'auckland',
            'christchurch',
            'wellington',
            'hamilton',
            'tauranga',
            'dunedin',
            'palmerston north',
            'napier',
            'porirua',
            'new plymouth',
            'rotorua',
        ];

        foreach ($cities as $city) {
            $cities = $this->zomato->cities(['q' => $city]);
            $cities = json_decode($cities);

            if (empty($cities->location_suggestions)) {
                continue;
            }

            foreach ($cities->location_suggestions as $location) {
                if (strcasecmp($location->country_name, 'new zealand') !== 0) {
                    continue;
                }
                $dbcity = City::where('id', $location->id)->first();

                if (empty($dbcity)) {
                    $dbcity = new City();
                }
                // Update the details in case
                $dbcity->id = $location->id;
                $dbcity->name = $location->name;
                $dbcity->country_id = $location->country_id;
                $dbcity->save();

            }
        }

        return;
    }

    protected function getCuisines()
    {
        $cities = City::get();

        foreach ($cities as $city) {
            $cuisines = $this->zomato->cuisines(['city_id' => $city->id]);
            $cuisines = json_decode($cuisines);

            if (empty($cuisines)) {
                continue;
            }

            foreach ($cuisines->cuisines as $cuisine) {

                if (empty($cuisine->cuisine->cuisine_name) || stripos($cuisine->cuisine->cuisine_name, 'coffee') === false) {
                    continue;
                }

                $c = new Cuisine();
                $c->city_id = $city->id;
                $c->cuisine_id = $cuisine->cuisine->cuisine_id;
                $c->name = $cuisine->cuisine->cuisine_name;
                $c->save();
            }

        }
        return;
    }

    protected function getAllCitiesCafes()
    {
        $cities = City::get();
        $cities=[ (object)[ 'id'=>70]];

        foreach ($cities as $city) {
            $morerequired = true;

            $types = ['distance' => ['asc', 'desc'], 'cost' => ['asc', 'desc'], 'rating' => ['asc', 'desc']];

            $start = 0;
            while ($morerequired) {

                $result = $this->zomato->search([
                    'start' => $start,
                    'count' => static::COUNT,
                    'cuisines' => 161,
                    'entity_id' => $city->id,
                    'entity_type' => 'city',
                    'sort' => 'distance',
                    'order' => 'asc'
                ]);

                $result = json_decode($result);

                if (empty($result->restaurants)) {
                    $morerequired = false;
                    continue;
                }

                foreach ($result->restaurants as $restaurant) {
                    $restaurant = $restaurant->restaurant;

                    if (empty($restaurant->id)) {
                        continue;
                    }

                    $cafe = Cafe::where('service', 'zomato')->where('id', $restaurant->id)->first();

                    // just update a couple things
                    if (!empty($cafe)) {
                        continue;
                    }

                    $cafe = new ZomatoCafe();
                    $cafe->name = $restaurant->name ?? '';
                    $cafe->id = $restaurant->id ?? '';
                    $cafe->url = $restaurant->url ?? '';
                    $cafe->phone = $restaurant->phone_numbers ?? '';
                    $cafe->address = $restaurant->location->address ?? '';
                    $cafe->city = $restaurant->location->city ?? '';
                    $cafe->city_id = $restaurant->location->city_id ?? '';
                    $cafe->latitude = $restaurant->location->latitude ?? '';
                    $cafe->longitude = $restaurant->location->longitude ?? '';
                    $cafe->zipcode = $restaurant->location->zipcode ?? '';
                    $cafe->country_id = $restaurant->location->country_id ?? '';
                    $cafe->locality_verbose = $restaurant->location->locality_verbose ?? '';
                    $cafe->cuisines = $restaurant->cuisines ?? '';
                    $cafe->timings = $restaurant->timings ?? '';
                    $cafe->averagecost = $restaurant->average_cost_for_two ?? '';
                    $cafe->price_range = $restaurant->price_range ?? '';
                    $cafe->currency = $restaurant->currency ?? '';
                    $cafe->highlights = json_encode($restaurant->highlights);
                    $cafe->zomato_rating = $restaurant->user_rating->aggregate_rating;
                    $cafe->zomato_ratingtext = $restaurant->user_rating->rating_text;
                    $cafe->zomato_votes = $restaurant->user_rating->votes;
                    $cafe->zomato_menuurl = $restaurant->menu_url;
                    $cafe->zomato_image = $restaurant->featured_image;
                    $cafe->zomato_thumb = $restaurant->thumb;
                    $cafe->save();

                }

                $start += static::COUNT;

                sleep(1);

                if (!empty($result->results_found) && $start >= $result->results_found) {
                    dd($start, $result);
                    $morerequired = false;
                }
            }
        }
        dd('completed');
    }
}
