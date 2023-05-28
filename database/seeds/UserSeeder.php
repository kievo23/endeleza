<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(\App\User::class, 4)->create();

        $user = \App\User::create([
            'email' => 'kelvinchege@gmail.com',
            'password' => Hash::make('12345678'),
            'active' => 1,
            'name' => 'kelvin Chege'
        ]);
    }
}
