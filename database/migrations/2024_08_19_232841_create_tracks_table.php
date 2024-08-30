<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tracker_id');
            $table->unsignedInteger('project_id');
            $table->integer('seconds');
            $table->timestamps();

            $table->foreign('tracker_id')
                ->references('id')
                ->on('trackers')
                ->onDelete('cascade');

            $table->foreign('project_id')
                ->references('id')
                ->on('trackers')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
