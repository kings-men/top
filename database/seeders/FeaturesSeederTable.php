<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FeaturesSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('features')->delete();

        \DB::table('features')->insert(array (

            array (
                'title' => 'Job Posting(Instant and Schedule)'
            ),
            array (
                'title' => 'End to End customer care suport'
            ),
            array (
                'title' => 'Standard pricing for the job upfront(No Surprises)'
            ),
            array (
                'title' => 'Conflict Resolution'
            ),
            array (
                'title' => 'Part Procurement Assistance'
            ),
            array (
                'title' => 'No Soliciting calls from the contractors'
            ),

            array (
                'title' => 'Jobs Analytics'
            ),
            array (
                'title' => 'Monthly Review'
            ),
            array (
                'title' => 'Easy payment process to Contractors'
            ),
            array (
                'title' => 'Accounting Software friendly'
            ),
            array (
                'title' => 'Easy payment process to Contractors'
            ),
            array (
                'title' => 'Export Job Data and Expenses'
            ),
            array (
                'title' => 'Job Posting(Instant and Schedule)'
            ),
            array (
                'title' => 'End to End customer care support'
            ),


            array (
                'title' => 'End to End customer care support'
            ),
            array (
                'title' => 'End to End customer care support'
            ),

            array (
                'title' => 'Standard pricing for the job upfront (No Surprises)'
            ),
            array (
                'title' => 'Conflict Resolution'
            ),
            array (
                'title' => 'Part Procurement Assistance'
            ),
            array (
                'title' => 'Jobs Analytics '
            ),
            array (
                'title' => 'Monthly Review'
            ),
            array (
                'title' => 'No Soliciting calls from the contractors'
            ),
            array (
                'title' => 'Equipment Tagging'
            ),
            array (
                'title' => 'Preventative maintenance schedules and reminders'
            ),
            array (
                'title' => 'Preferred technician selection'
            ),
            array (
                'title' => 'Schedule to do list and Wish list jobs'
            ),
            array (
                'title' => 'Discount and promos'
            ),
            array (
                'title' => 'Consulting services'
            ),


            array (
                'title' => 'Access to Forum/ Discussion board'
            ),
            array (
                'title' => 'Wide Service categories'
            ),
            array (
                'title' => 'Preferred Customer support'
            ),
            array (
                'title' => 'Mercenary Help'
            ),
            array (
                'title' => 'Multiple User including Staff '
            ),
            array (
                'title' => 'Warranty Assistance'
            ),
            array (
                'title' => 'Easy payment process to Contractors'
            ),
            array (
                'title' => 'Accounting Software friendly'
            ),
            array (
                'title' => 'Export Job Data and Expenses'
            ),
            array (
                'title' => 'Previous Jobs completed on Equipments'
            ),

        ));
    }
}
