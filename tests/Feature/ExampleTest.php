<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends TestCase
{
    
    //use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLoginPage()
    {
        $response = $this->get('/login');

        $response->assertSee('Remember Me');
    }

    public function testCantViewDashboardWithoutAuthentication()
    {
        # Assert that unauthenticated users can not access dashboard
        
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    public function testInitDatabase(){
        //migrate database to sqlite and seed tables
        //$this->artisan('migrate');
        Artisan::call('migrate:fresh --env=testing');
        Artisan::call('db:seed --env=testing');

        $usersCount = User::all()->count();

        $this->assertEquals(5, $usersCount);
    }

    public function testCreateAndAuthenticateUser(){
        $user = User::find(['id' => 5])->first();
 
        $response = $this->actingAs($user)
                         ->withSession(['foo' => 'bar'])
                         ->get('/');
        $response->assertStatus(200);

    }

    public function testCustomerLink(){
        $user = User::find(['id' => 5])->first();
 
        $response = $this->actingAs($user)
                         ->withSession(['foo' => 'bar'])
                         ->get('/customers');

        $response->assertStatus(200);
    }

    public function testPersonLink(){
        $user = User::find(['id' => 5])->first();
 
        $response = $this->actingAs($user)
                         ->withSession(['foo' => 'bar'])
                         ->get('/persons');
                         
        $response->assertStatus(200);
    }

    public function testLoanRequestLink(){
        $user = User::find(['id' => 5])->first();
 
        $response = $this->actingAs($user)
                         ->withSession(['foo' => 'bar'])
                         ->get('/loan_requests');
                         
        $response->assertStatus(200);
    }

    public function testTransactionsLink(){
        $user = User::find(['id' => 5])->first();
 
        $response = $this->actingAs($user)
                         ->withSession(['foo' => 'bar'])
                         ->get('/transactions');
                         
        $response->assertStatus(200);
    }
}
