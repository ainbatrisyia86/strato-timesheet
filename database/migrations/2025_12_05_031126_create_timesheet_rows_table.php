<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timesheet_rows', function (Blueprint $table) {
            $table->id();

            // Link to weekly timesheet
            $table->unsignedBigInteger('timesheet_id');
            $table->foreign('timesheet_id')
                  ->references('id')
                  ->on('timesheets')
                  ->onDelete('cascade');

            // Daily entries
            $table->date('date')->nullable();
            $table->string('project')->nullable();
            $table->text('task')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            // Auto-calculated hours
            $table->decimal('total_hours', 5, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timesheet_rows');
    }
};

