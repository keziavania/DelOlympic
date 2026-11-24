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
        Schema::create('competition_registrations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('competition_id')->constrained()->cascadeOnDelete();
            $table->string('registration_number', 50)->unique();
            $table->string('branch', 120)->nullable();
            $table->string('team_name', 120)->nullable();
            $table->json('team_members')->nullable();
            $table->string('status', 40)->default('menunggu_pembayaran');
            $table->string('payment_proof_path')->nullable();
            $table->string('student_card_path')->nullable();
            $table->string('recommendation_letter_path')->nullable();
            $table->timestamp('payment_submitted_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->string('result_status', 40)->nullable();
            $table->decimal('score', 6, 2)->nullable();
            $table->string('certificate_code', 60)->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'competition_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competition_registrations');
    }
};
