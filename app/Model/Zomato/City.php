<?php

namespace App\Model\Zomato;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'zomato_cities';
    protected $primaryKey = 'cityid';
}
