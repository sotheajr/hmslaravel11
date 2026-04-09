<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('shiftlists', function (Blueprint $table) {
        $table->id();
        $table->string('shift_name');
        $table->time('min_start_time');
        $table->time('start_time');
        $table->time('max_start_time');
        $table->time('min_end_time');
        $table->time('end_time');
        $table->time('max_end_time');
        $table->integer('break_time')->nullable();
        $table->string('status')->default('Active');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shiftlists');
    }
};
