<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('services')->delete();

        \DB::table('services')->insert(array (
            array (
                'id' => 1,
                'name' => 'Plumber',
                'description' => 'plumber related data',
                'order' => '1',
                'status' => '1',
            ),
            array (
                'id' => 2,
                'name' => 'Tabs',
                'description' => 'Tabs related data',
                'order' => '2',
                'status' => '1',
            ),
            array (
                'id' => 3,
                'name' => 'Machanics',
                'description' => 'Machanics related data',
                'order' => '3',
                'status' => '1',
            ),

        ));


    }
}
