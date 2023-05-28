<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_notification', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_stall_id')->nullable();
            $table->integer('notification_identifier')->nullable();
            $table->string('receipt_number');
            $table->float('amount');
            $table->integer('delivery_id')->nullable();
            $table->dateTime('delivery_date');
            $table->integer('route_team_id')->nullable();
            $table->integer('twiga_customer_id')->nullable();
            $table->integer('till_number')->nullable();
            $table->integer('customer_id');
            $table->string('phone')->nullable();
            $table->integer('status')->nullable();
            $table->integer('deleted')->nullable();
            $table->text('payload')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('delivery_notification');
    }
}
