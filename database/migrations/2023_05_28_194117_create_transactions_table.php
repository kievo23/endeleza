<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_id');
            $table->string('payer_names')->nullable();
            $table->integer('gl_account_id')->nullable();
            $table->integer('loan_account_id')->nullable();
            $table->string('msisdn');
            $table->string('paid_by')->nullable();
            $table->string('transaction_reference')->nullable();
            $table->float('transaction_amount');
            $table->integer('debit')->nullable();
            $table->integer('credit')->nullable();
            $table->integer('gl_debit')->nullable();
            $table->integer('gl_credit')->nullable();
            $table->dateTime('transaction_time')->nullable();
            $table->integer('transaction_status')->nullable();
            $table->string('transaction_type')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
