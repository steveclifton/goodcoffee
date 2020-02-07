<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewforCafes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW cafes AS
            (SELECT `cafeid`, `name`, `service`, `city`,`address`, `latitude`, `longitude`, `country` FROM `allpress_cafes`)
            UNION
            (SELECT `cafeid`, `name`, `service`, `city`,`address`, `latitude`, `longitude`, `country` FROM `zomato_cafes`)
            UNION
            (SELECT `cafeid`, `name`, `service`, `city`,`address`, `latitude`, `longitude`, `country` FROM `supreme_cafes`)
            UNION
            (SELECT `cafeid`, `name`, `service`, `city`,`address`, `latitude`, `longitude`, `country` FROM `other_cafes`);
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
