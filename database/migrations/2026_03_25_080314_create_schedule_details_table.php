<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedule_details', function (Blueprint $table) {
    $table->id();
    $table->foreignId('schedule_id')->constrained()->cascadeOnDelete();

    $table->date('work_date');

    $table->time('start_time')->nullable();
    $table->time('end_time')->nullable();

    $table->integer('break_time')->nullable();
    $table->integer('total_hours')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_details');
    }
};
