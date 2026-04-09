<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experience_information', function (Blueprint $table) {
            $table->id();
              $table->string('user_id', 50)->nullable(); // Foreign key to users
            $table->string('company_name');
            $table->string('location')->nullable();
            $table->string('job_position')->nullable();
            $table->date('period_from')->nullable();
            $table->date('period_to')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experience_information');
    }
};