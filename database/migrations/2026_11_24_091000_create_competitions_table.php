<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('competitions', function (Blueprint $table): void {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('short_title', 100);
            $table->string('subtitle', 120)->nullable();
            $table->string('organizer');
            $table->string('category', 50);
            $table->string('category_label', 100);
            $table->string('participation_type', 30)->default('individu');
            $table->unsignedTinyInteger('min_team_members')->default(1);
            $table->unsignedTinyInteger('max_team_members')->default(1);
            $table->json('education_levels');
            $table->string('education_label', 150);
            $table->string('status', 30)->default('buka');
            $table->unsignedInteger('registration_fee')->default(0);
            $table->string('fee_unit', 30)->default('Peserta');
            $table->unsignedInteger('quota')->default(500);
            $table->date('registration_start')->nullable();
            $table->date('registration_end')->nullable();
            $table->date('technical_meeting_date')->nullable();
            $table->date('event_date')->nullable();
            $table->date('final_date')->nullable();
            $table->string('total_prize_summary', 150)->nullable();
            $table->text('description');
            $table->json('prizes')->nullable();
            $table->json('syllabus')->nullable();
            $table->json('requirements')->nullable();
            $table->json('timeline')->nullable();
            $table->json('branches')->nullable();
            $table->string('theme_image')->nullable();
            $table->string('accent_color', 30)->default('blue');
            $table->string('icon_symbol', 20)->default('Σ');
            $table->string('guidebook_url')->nullable();
            $table->string('group_link')->nullable();
            $table->string('contact_person', 150)->nullable();
            $table->string('exam_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competitions');
    }
};
