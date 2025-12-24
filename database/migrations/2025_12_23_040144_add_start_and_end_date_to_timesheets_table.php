<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('timesheets', function (Blueprint $table) {
            // add columns WITHOUT touching foreign keys
            if (!Schema::hasColumn('timesheets', 'start_date')) {
                $table->date('start_date')->nullable()->after('user_id');
            }

            if (!Schema::hasColumn('timesheets', 'end_date')) {
                $table->date('end_date')->nullable()->after('start_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('timesheets', function (Blueprint $table) {
            if (Schema::hasColumn('timesheets', 'start_date')) {
                $table->dropColumn('start_date');
            }

            if (Schema::hasColumn('timesheets', 'end_date')) {
                $table->dropColumn('end_date');
            }
        });
    }
};
