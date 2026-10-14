<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->string('patron')->nullable()->after('description');
            $table->string('meeting_schedule')->nullable()->after('patron');
            $table->text('activities')->nullable()->after('meeting_schedule');
        });
    }

    public function down(): void
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->dropColumn(['patron', 'meeting_schedule', 'activities']);
        });
    }
};
