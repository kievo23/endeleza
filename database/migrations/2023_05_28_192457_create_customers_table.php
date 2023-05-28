<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('blocked')->nullable();
            $table->integer('active');
            $table->string('customer_account_msisdn');
            $table->integer('pin')->nullable();
            $table->string('salt_key')->nullable();
            $table->integer('pin_reset')->nullable();
            $table->float('account_limit')->nullable(); 
            $table->integer('person_id'); 
            $table->integer('agent_id')->nullable();
            $table->float('rollover')->nullable();
            $table->float('interest')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
