<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('s1_applications', function (Blueprint $table) {
            $table->index('created_at');
            $table->index('is_read');
            $table->index('index_number');
        });

        Schema::table('s5_applications', function (Blueprint $table) {
            $table->index('created_at');
            $table->index('is_read');
        });

        Schema::table('contact_messages', function (Blueprint $table) {
            $table->index('created_at');
            $table->index('is_read');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->index(['is_published', 'published_at']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->index(['is_published', 'starts_at']);
        });

        Schema::table('programme_entries', function (Blueprint $table) {
            $table->index(['is_published', 'starts_at']);
        });

        Schema::table('gallery_items', function (Blueprint $table) {
            $table->index(['is_published', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::table('s1_applications', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['is_read']);
            $table->dropIndex(['index_number']);
        });

        Schema::table('s5_applications', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['is_read']);
        });

        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['is_read']);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['is_published', 'published_at']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex(['is_published', 'starts_at']);
        });

        Schema::table('programme_entries', function (Blueprint $table) {
            $table->dropIndex(['is_published', 'starts_at']);
        });

        Schema::table('gallery_items', function (Blueprint $table) {
            $table->dropIndex(['is_published', 'sort_order']);
        });
    }
};
