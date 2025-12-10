<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('timesheets', function (Blueprint $table) {
            // Remove old columns that are not needed
            if (Schema::hasColumn('timesheets', 'role')) {
                $table->dropColumn('role');
            }
            if (Schema::hasColumn('timesheets', 'date')) {
                $table->dropColumn('date');
            }
            if (Schema::hasColumn('timesheets', 'project')) {
                $table->dropColumn('project');
            }
            if (Schema::hasColumn('timesheets', 'task')) {
                $table->dropColumn('task');
            }
            if (Schema::hasColumn('timesheets', 'total_hours')) {
                $table->dropColumn('total_hours');
            }

            // Add the new columns
            $table->integer('week')->after('user_id');
            $table->string('month')->after('week');
            $table->integer('year')->after('month');
        });
    }

    public function down(): void
    {
        Schema::table('timesheets', function (Blueprint $table) {
            $table->string('role')->nullable()->after('user_id');
            $table->date('date')->nullable()->after('role');
            $table->string('project')->nullable()->after('date');
            $table->string('task')->nullable()->after('project');
            $table->string('total_hours')->nullable()->after('task');

            $table->dropColumn(['week', 'month', 'year']);
        });
    }
};
