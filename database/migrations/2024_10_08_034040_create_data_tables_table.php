<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('data_tables', function (Blueprint $table) {
            $table->id();
            $table->string('table_name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('table_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_table_id')->constrained('data_tables')->onDelete('cascade');
            $table->string('field_name');
            $table->string('field_type');
            $table->timestamps();
        });

        Schema::create('table_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_table_id')->constrained('data_tables')->onDelete('cascade');
            $table->json('data');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('table_records');
        Schema::dropIfExists('table_fields');
        Schema::dropIfExists('data_tables');
    }
};