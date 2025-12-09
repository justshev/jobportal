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
            // Rename location to full_address
            $table->renameColumn('location', 'full_address');
            
            // Add detailed location fields
            $table->string('province')->nullable()->after('company_name');
            $table->string('city')->nullable()->after('province');
            $table->string('district')->nullable()->after('city');
            $table->decimal('latitude', 10, 8)->nullable()->after('district');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_postings', function (Blueprint $table) {
            $table->dropColumn(['province', 'city', 'district', 'latitude', 'longitude']);
            $table->renameColumn('full_address', 'location');
        });
    }
};
