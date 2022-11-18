<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ServiceTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('services')->delete();
        \DB::table('services')->insert(array (

            array (
                'name'          => 'All',
                'description'   => 'All',
                'order'         => 1,
                'status'        =>1,
            ),
            array (
                'name'          => 'Repair',
                'description'   => 'Repair',
                'order'         => 1,
                'status'        =>1,
            ),
            array (
                'name'          => 'Tabs',
                'description'   => 'Tabs',
                'order'         => 1,
                'status'        =>1,
            ),
            array (
                'name'          => 'Mechanic',
                'description'   => 'Mechanic',
                'order'         => 1,
                'status'        =>1,
            ),
            array (
                'name'          => 'Plumbing',
                'description'   => 'Plumbing',
                'order'         => 1,
                'status'        =>1,
            )

        ));
    }
}
