<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('s5_applications', function (Blueprint $table) {
            $table->id();
            $table->string('surname');
            $table->string('first_name');
            $table->string('other_names')->nullable();
            $table->string('gender');
            $table->string('religion');
            $table->string('previous_school')->nullable();
            $table->string('uce_english');
            $table->string('uce_mathematics');
            $table->string('uce_biology');
            $table->string('uce_chemistry');
            $table->string('uce_physics');
            $table->string('uce_history');
            $table->string('uce_geography');
            $table->string('uce_cre')->nullable();
            $table->string('uce_literature')->nullable();
            $table->string('uce_french')->nullable();
            $table->string('uce_luganda')->nullable();
            $table->string('uce_fine_art')->nullable();
            $table->string('uce_kiswahili')->nullable();
            $table->string('uce_ict')->nullable();
            $table->string('uce_entrepreneurship')->nullable();
            $table->string('uce_physical_education')->nullable();
            $table->string('uce_ire')->nullable();
            $table->string('uce_nutrition')->nullable();
            $table->string('uce_agriculture')->nullable();
            $table->string('uce_technical_drawing')->nullable();
            $table->string('uce_project_work');
            $table->string('uce_result');
            $table->string('ple_aggregates');
            $table->string('division');
            $table->text('preferred_combinations');
            $table->text('career_interests')->nullable();
            $table->text('co_curricular_activities')->nullable();
            $table->text('former_school_responsibilities')->nullable();
            $table->string('guardian_name');
            $table->string('guardian_address')->nullable();
            $table->string('guardian_phone');
            $table->string('result_slip')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('s5_applications');
    }
};
