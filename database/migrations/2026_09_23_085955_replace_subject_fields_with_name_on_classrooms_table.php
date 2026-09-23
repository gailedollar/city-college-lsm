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
        Schema::table('classrooms', function (Blueprint $table) {
            $table->renameColumn('subject_name', 'name');
            $table->dropColumn(['subject_code', 'subject_description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classrooms', function (Blueprint $table) {
            $table->renameColumn('name', 'subject_name');
            $table->string('subject_code')->default('');
            $table->text('subject_description')->default('');
        });
    }
};
