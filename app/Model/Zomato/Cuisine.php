<?php

namespace App\Model\Zomato;

use Illuminate\Database\Eloquent\Model;

class Cuisine extends Model
{
    protected $table = 'zomato_cuisines';
    protected $primaryKey = 'cuisineid';

}
