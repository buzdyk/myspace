<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trackers', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('helper');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trackers');
    }
};
