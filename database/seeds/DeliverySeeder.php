<?php

use Illuminate\Database\Seeder;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(\App\DeliveryNotification::class,20)->create();
    }
}
