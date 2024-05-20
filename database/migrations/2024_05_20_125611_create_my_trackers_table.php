<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('my_trackers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tracker_id');
            $table->string('label')
                ->nullable()
                ->default(null);
            $table->string('secret');
            $table->timestamps();

            $table->foreign('tracker_id')
                ->references('id')
                ->on('trackers')
                ->onDelete('CASCADE');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('my_trackers');
    }
};
