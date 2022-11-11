<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CuisineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        \DB::table('cuisines')->delete();

        \DB::table('cuisines')->insert(array (
            array (
                'name' => 'French',
                'created_at' => '2021-05-28 15:59:15',
                'updated_at' => NULL
            ),
            array (
                'name' => 'Normal',
                'created_at' => '2021-05-28 15:59:15',
                'updated_at' => NULL,
            ),
            array (
                'name' => 'Chinese',
                'created_at' => '2021-05-28 15:59:15',
                'updated_at' => NULL,
            ),
            array (
                'name' => 'Japanese',
                'created_at' => '2021-05-28 15:59:15',
                'updated_at' => NULL,
            ),
            array (
                'name' => 'Indian',
                'created_at' => '2021-05-28 15:59:15',
                'updated_at' => NULL,
            ),
            array (
                'name' => 'Italian',
                'created_at' => '2021-05-28 15:59:15',
                'updated_at' => NULL,
            ),
            array (
                'name' => 'Greek',
                'created_at' => '2021-05-28 15:59:15',
                'updated_at' => NULL,
            ),
            array (
                'name' => 'Spanish',
                'created_at' => '2021-05-28 15:59:15',
                'updated_at' => NULL,
            ),
            array (
                'name' => 'Lebanese',
                'created_at' => '2021-05-28 15:59:15',
                'updated_at' => NULL,
            ),
            array (
                'name' => 'Moroccan',
                'created_at' => '2021-05-28 15:59:15',
                'updated_at' => NULL,
            ),
            array (
                'name' => 'Turkish',
                'created_at' => '2021-05-28 15:59:15',
                'updated_at' => NULL,
            ),
            array (
                'name' => 'Thai',
                'created_at' => '2021-05-28 15:59:15',
                'updated_at' => NULL,
            ),
        ));


    }
}
