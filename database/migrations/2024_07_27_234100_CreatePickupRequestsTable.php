<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePickupRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('pickup_requests', function (Blueprint $table) {
            $table->id(); // This automatically creates an auto-incrementing primary key column named 'id'
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('pickup_date');
            $table->time('pickup_time');
            $table->string('pickup_address');
            $table->string('payment_preference');
            $table->string('pickup_status')->default('Pending');
            $table->timestamps(); // This adds 'created_at' and 'updated_at' columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('pickup_requests');
    }
}

