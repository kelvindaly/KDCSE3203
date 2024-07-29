<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRoleColumnInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 50)->change(); // Increase the length to 50 or desired length
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->change(); // Revert to original length if needed
        });
    }
}
