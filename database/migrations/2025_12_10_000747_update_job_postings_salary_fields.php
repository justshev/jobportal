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
        Schema::table('job_postings', function (Blueprint $table) {
            $table->dropColumn('salary_range');
            $table->decimal('salary_min', 15, 2)->nullable()->after('employment_type');
            $table->decimal('salary_max', 15, 2)->nullable()->after('salary_min');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_postings', function (Blueprint $table) {
            $table->string('salary_range')->nullable();
            $table->dropColumn(['salary_min', 'salary_max']);
        });
    }
};
