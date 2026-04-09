<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('education_information', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 50)->nullable(); // nullable user code
            $table->string('institution');
            $table->string('subject');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('degree')->nullable();
            $table->string('grade')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('education_information');
    }
};