<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagePrioritiesTable extends Migration
{
    public function up()
    {
        Schema::create('package_priorities', function (Blueprint $table) {
            $table->id();
            $table->string('priority_name');
            $table->decimal('priority_rate', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('package_priorities');
    }
}
