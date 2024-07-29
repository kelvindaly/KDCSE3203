<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageSizesTable extends Migration
{
    public function up()
    {
        Schema::create('package_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('size_range');
            $table->decimal('size_rate', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('package_sizes');
    }
}
