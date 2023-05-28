<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('surname')->nullable(); 
            $table->string('first_name')->nullable(); 
            $table->string('other_names')->nullable(); 
            $table->string('gender')->nullable();
            $table->string('twiga_response')->nullable();
            $table->dateTime('date_of_birth')->nullable(); 
            $table->integer('id_number');
            $table->string('primary_msisdn');
            $table->string('alternate_msisdn')->nullable(); 
            $table->string('postal_address')->nullable(); 
            $table->string('physical_location')->nullable();
            $table->string('business_name')->nullable();
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
        Schema::dropIfExists('person');
    }
}
