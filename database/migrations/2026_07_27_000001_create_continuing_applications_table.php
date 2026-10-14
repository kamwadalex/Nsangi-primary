<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('continuing_applications')) {
            return;
        }

        Schema::create('continuing_applications', function (Blueprint $table) {
            $table->id();
            $table->string('surname');
            $table->string('first_name');
            $table->string('other_names')->nullable();
            $table->string('sex');
            $table->date('date_of_birth');
            $table->unsignedTinyInteger('age');
            $table->string('religion');
            $table->string('passport_photo');
            $table->string('current_class');
            $table->string('previous_secondary_school');
            $table->string('previous_class');
            $table->string('student_type');
            $table->string('index_number')->nullable();
            $table->text('reason_for_transfer');
            $table->string('report_card');
            $table->text('co_curricular_activities');
            $table->string('dream_profession')->nullable();
            $table->string('guardian_name');
            $table->string('guardian_phone');
            $table->string('guardian_address')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('continuing_applications');
    }
};
