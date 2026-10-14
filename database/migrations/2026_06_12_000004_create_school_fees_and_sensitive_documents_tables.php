<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_fees', function (Blueprint $table) {
            $table->id();
            $table->string('class');
            $table->string('item');
            $table->string('day_students')->nullable();
            $table->string('boarding_students')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('sensitive_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->default('notes');
            $table->text('description')->nullable();
            $table->string('file')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sensitive_documents');
        Schema::dropIfExists('school_fees');
    }
};
