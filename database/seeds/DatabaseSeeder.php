<?php

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    use RefreshDatabase;
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(SMSSeeder::class);
        $this->call(PersonSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(DeliverySeeder::class);
        $this->call(LoanSeeder::class);
        $this->call(TransactionSeeder::class);
    }
}
