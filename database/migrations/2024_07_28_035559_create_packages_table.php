<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('pickup_request_id')->constrained('pickup_requests')->onDelete('cascade');
            $table->foreignId('zone_id')->constrained('zones')->onDelete('cascade');
            $table->foreignId('priority_id')->constrained('package_priorities')->onDelete('cascade');
            $table->foreignId('size_id')->constrained('package_sizes')->onDelete('cascade');
            $table->string('recipient_name');
            $table->string('recipient_address');
            $table->string('recipient_email')->nullable();
            $table->string('recipient_phone');
            $table->decimal('cost', 10, 2); // Store the calculated cost
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}

