<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_account', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_account_id');
            $table->integer('delivery_id');
            $table->float('principal_amount');
            $table->float('interest_charged')->nullable();
            $table->float('trn_charge')->nullable();
            $table->float('loan_amount');
            $table->float('loan_balance');
            $table->float('loan_penalty')->nullable();
            $table->integer('loan_status');
            $table->integer('days_in_arrears')->nullable();
            $table->integer('hours_in_arrears')->nullable();
            $table->integer('deleted')->nullable();
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
        Schema::dropIfExists('loan_account');
    }
}
