<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('primary_applications', function (Blueprint $table) {
            $table->id();
            $table->string('child_name');
            $table->date('date_of_birth');
            $table->string('class_applying_for');
            $table->string('attendance_type');
            $table->string('guardian_name');
            $table->string('guardian_phone', 50);
            $table->string('guardian_email')->nullable();
            $table->text('message')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->index(['is_read', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('primary_applications');
    }
};
