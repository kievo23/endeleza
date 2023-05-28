<?php

use Illuminate\Database\Seeder;

class SMSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Outbox::class, 35)->create();
    }
}
