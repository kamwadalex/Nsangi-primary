<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('s1_applications', function (Blueprint $table) {
            $table->id();
            $table->string('surname');
            $table->string('first_name');
            $table->string('other_names')->nullable();
            $table->string('sex');
            $table->date('date_of_birth');
            $table->unsignedTinyInteger('age');
            $table->string('religion');
            $table->string('passport_photo');
            $table->string('former_primary_school');
            $table->string('index_number');
            $table->string('ple_english');
            $table->string('ple_mathematics');
            $table->string('ple_social_studies');
            $table->string('ple_science');
            $table->unsignedTinyInteger('total_aggregates');
            $table->string('division');
            $table->string('result_slip');
            $table->string('first_choice')->nullable();
            $table->string('second_choice')->nullable();
            $table->string('third_choice')->nullable();
            $table->text('co_curricular_activities');
            $table->string('dream_profession')->nullable();
            $table->string('guardian_name');
            $table->string('guardian_phone');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('s1_applications');
    }
};
