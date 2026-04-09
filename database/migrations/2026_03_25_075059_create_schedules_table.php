<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('department_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('designation_id')
                ->constrained()
                ->cascadeOnDelete();

            // ✅ Shift relation
            $table->foreignId('shiftlist_id')
                ->constrained('shiftlists')
                ->cascadeOnDelete();

            // ✅ Replace year + month
            $table->date('work_date');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};