<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function calculatedistance($pm_pointa, $pm_pointb)
    {

        // Init Point A
        $la_pointa = is_object($pm_pointa) ? (array) $pm_pointa : $pm_pointa;

        $li_fromlat = $la_pointa['latitude'] ?? $la_pointa['lat'] ?? null;
        $li_fromlat = is_scalar($li_fromlat) ? floatval($li_fromlat) : 0.0;

        $li_fromlng = $la_pointa['longitude'] ?? $la_pointa['lon'] ?? null;
        $li_fromlng = is_scalar($li_fromlng) ? floatval($li_fromlng) : 0.0;


        // Init Point B
        $la_pointb = is_object($pm_pointb) ? (array) $pm_pointb : $pm_pointb;

        $li_tolat = $la_pointb['latitude'] ?? $la_pointb['lat'] ?? null;
        $li_tolat = is_scalar($li_tolat) ? floatval($li_tolat) : 0.0;

        $li_tolng = $la_pointb['longitude'] ?? $la_pointb['lon'] ?? null;
        $li_tolng = is_scalar($li_tolng) ? floatval($li_tolng) : 0.0;



        if (($li_fromlat < -90.0 || $li_fromlat > 90.0) || ($li_tolat < -90.0 || $li_tolat > 90.0)) {
            return false;
        }

        if (($li_fromlng < -180.0 || $li_fromlng > 180.0) || ($li_tolng < -180.0 || $li_tolng > 180.0)) {
            return false;
        }

        $li_earthradius = 6371000; // Earth's radio in metres (use 3959 for miles)

        // Convert from degrees to radians
        $li_fromlat = deg2rad($li_fromlat);
        $li_fromlng = deg2rad($li_fromlng);
        $li_tolat = deg2rad($li_tolat);
        $li_tolng = deg2rad($li_tolng);

        $li_latdiff = $li_tolat - $li_fromlat;
        $li_lngdiff = $li_tolng - $li_fromlng;

        $li_angle = 2 * asin(sqrt(pow(sin($li_latdiff / 2), 2) + cos($li_fromlat) * cos($li_tolat) * pow(sin($li_lngdiff / 2), 2)));

        $li_distance = $li_angle * $li_earthradius;
        $li_distance = round($li_distance);

        return $li_distance;
    }
}
