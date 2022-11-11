<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('countries')->delete();

        \DB::table('countries')->insert(array (
            array (
                'id' => 1,
                'code' => 'US',
                'name' => 'United States',
                'dial_code' => 1,
                'currency_name' => 'United States dollar',
                'symbol' => '$',
                'currency_code' => 'USD',
            )
        ));


    }
}
