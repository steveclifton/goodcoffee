<?php

namespace App\Http\Controllers;

use App\Model\Cafe;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getClosestCafesByIp()
    {
        $user = geoip('185.195.239.242');

        if (empty($user->lat) || empty($user->lon)) {
            return [];
        }

        $userLocation = [];
        $userLocation['latitude'] = $user->lat;
        $userLocation['longitude'] = $user->lon;

        $cafes = Cafe::where('country', $user->country)->get();

        $this->addDistanceToCafes($userLocation, $cafes);

        return $this->formatReturn($cafes);
    }

    public function getClosestCafesByGPS(Request $request)
    {
        if (empty($request->latitude) || empty($request->longitude)) {
            return null;
        }

        $userLocation = [];
        $userLocation['latitude'] = $request->latitude;
        $userLocation['longitude'] = $request->longitude;

        $cafes = Cafe::get();

        $this->addDistanceToCafes($userLocation, $cafes);


        return $this->formatReturn($cafes);
    }

    private function addDistanceToCafes($userLocation, $cafes)
    {
        foreach ($cafes as $cafe) {
            $cafeLocation = [];
            $cafeLocation['latitude'] = $cafe->latitude;
            $cafeLocation['longitude'] = $cafe->longitude;

            $cafe->distance = $this->calculatedistance($userLocation, $cafeLocation);
        }
    }

    private function formatReturn($cafes)
    {
        $sorted = $cafes->sortby('distance');
        $return = [];

        foreach ($sorted->slice(0, 20) as $cafe) {
            $caf = new \stdClass;
            $caf->name = $cafe->name;
            $caf->distance = $cafe->distance;
            $caf->latitude = $cafe->latitude;
            $caf->longitude = $cafe->longitude;
            $caf->city = $cafe->city;
            $caf->address = $cafe->address;
            $return[$cafe->name] = $caf;
        }

        return $return;
    }
}
