<?php

namespace App\Http\Controllers\Supreme;

use App\Http\Controllers\Controller;
use App\SupremeCafe;
use Illuminate\Http\Request;

class SupremeController extends Controller
{
    protected function importCafes()
    {

        $row = 0;
        $path = storage_path() . "/imports/supreme.csv";

        if (($handle = fopen($path, "r")) !== FALSE) {

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (0 == $row++) {
                    continue;
                }

               $resturant = SupremeCafe::where('place_id', $data[13])->first();

                if (!empty($resturant)) {
                    continue;
                }

                $cafe = new SupremeCafe();
                $cafe->name = $data[0] ?? '';
                $cafe->handle = $data[1] ?? '';
                $cafe->address = ($data[2] ?? '') . ',' . ($data[3]);
                $cafe->city = $data[4] ?? '';
                $cafe->zip = $data[7] ?? '';
                $cafe->phone = $data[8] ?? '';
                $cafe->website = $data[9] ?? '';
                $cafe->instagram_handle = $data[10] ?? '';
                $cafe->tags = $data[11] ?? '';
                $cafe->country = $data[12] ?? '';
                $cafe->place_id = $data[13] ?? '';
                $cafe->latitude = $data[14] ?? '';
                $cafe->longitude = $data[15] ?? '';
                $cafe->save();
            }
            fclose($handle);
        }

    }
}
