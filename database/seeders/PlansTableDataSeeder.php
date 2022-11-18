<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PlansTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('plans')->delete();
        \DB::table('plans')->insert(array (
            array (
                'id' => 1,
                'title' => 'Free plan',
                'identifier' => 'free',
                'type' => 'monthly',
                'amount' => 99,
                'trial_period' => 7,
                'status' => 1,
                'plan_price_id'=>'price_1M4fwXCtcJnsPYPIPbsm46A4',
                'created_at' => '2022-03-10 11:26:15',
                'updated_at' => '2022-03-10 11:26:15',
            ),
            array (
                'id' => 2,
                'title' => 'Basic plan',
                'identifier' => 'basic',
                'type' => 'annualy',
                'amount' => 999,
                'trial_period' => NULL,
                'status' => 1,
                'plan_price_id'=>'price_1M4fxvCtcJnsPYPIOY4SBwAG',
                'created_at' => '2022-03-10 11:26:15',
                'updated_at' => '2022-03-10 11:26:15',
            )
        ));
    }
}
