<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sensitive_sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        $sections = [
            ['name' => 'Holiday Work', 'slug' => 'holiday-work', 'sort_order' => 1, 'is_published' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Notes & Files', 'slug' => 'notes', 'sort_order' => 2, 'is_published' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'School Circular', 'slug' => 'school-circular', 'sort_order' => 3, 'is_published' => true, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('sensitive_sections')->insert($sections);

        $sectionIds = DB::table('sensitive_sections')->pluck('id', 'slug');

        Schema::table('sensitive_documents', function (Blueprint $table) {
            $table->foreignId('sensitive_section_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
            $table->string('original_filename')->nullable()->after('file');
            $table->unsignedBigInteger('file_size')->nullable()->after('original_filename');
        });

        foreach (DB::table('sensitive_documents')->get() as $document) {
            $sectionId = $sectionIds[$document->category] ?? $sectionIds['notes'];

            DB::table('sensitive_documents')->where('id', $document->id)->update([
                'sensitive_section_id' => $sectionId,
                'original_filename' => $document->file ? basename($document->file) : null,
            ]);
        }

        Schema::table('sensitive_documents', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    public function down(): void
    {
        Schema::table('sensitive_documents', function (Blueprint $table) {
            $table->string('category')->default('notes')->after('title');
        });

        $sectionSlugs = DB::table('sensitive_sections')->pluck('slug', 'id');

        foreach (DB::table('sensitive_documents')->get() as $document) {
            DB::table('sensitive_documents')->where('id', $document->id)->update([
                'category' => $sectionSlugs[$document->sensitive_section_id] ?? 'notes',
            ]);
        }

        Schema::table('sensitive_documents', function (Blueprint $table) {
            $table->dropConstrainedForeignId('sensitive_section_id');
            $table->dropColumn(['original_filename', 'file_size']);
        });

        Schema::dropIfExists('sensitive_sections');
    }
};
