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
            $table->foreignId('timesheet_id')->constrained('timesheets')->onDelete('cascade'); // links to timesheets table
            $table->date('date');         // the date of the task
            $table->string('project');    // project name
            $table->string('task');       // task description
            $table->time('start_time');   // start time
            $table->time('end_time');     // end time
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timesheet_rows');
    }
};
