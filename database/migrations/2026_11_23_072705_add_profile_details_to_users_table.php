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
        Schema::table('users', function (Blueprint $table) {
            // Data Peserta Olimpiade
            $table->string('phone')->nullable()->after('email');
            $table->string('nisn', 20)->nullable()->after('phone');
            $table->string('gender', 20)->nullable()->after('nisn');
            $table->string('school_name')->nullable()->after('gender');
            $table->string('education_level', 50)->nullable()->after('school_name');
            $table->string('grade', 20)->nullable()->after('education_level');
            $table->string('province')->nullable()->after('grade');
            $table->string('city')->nullable()->after('province');

            // Data Lembaga / Penyelenggara
            $table->string('institution_name')->nullable()->after('city');
            $table->string('institution_type', 100)->nullable()->after('institution_name');
            $table->string('position', 100)->nullable()->after('institution_type');
            $table->text('institution_address')->nullable()->after('position');
            $table->string('institution_website')->nullable()->after('institution_address');
            $table->string('institution_phone', 30)->nullable()->after('institution_website');
            $table->string('document_link')->nullable()->after('institution_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'nisn',
                'gender',
                'school_name',
                'education_level',
                'grade',
                'province',
                'city',
                'institution_name',
                'institution_type',
                'position',
                'institution_address',
                'institution_website',
                'institution_phone',
                'document_link',
            ]);
        });
    }
};
