<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('table_records', function (Blueprint $table) {
            $table->string('month')->after('data_table_id');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }

    public function down()
    {
        Schema::table('table_records', function (Blueprint $table) {
            $table->dropColumn('month');
            $table->timestamps();
        });
    }
};