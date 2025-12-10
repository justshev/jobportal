<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Drop old columns if they exist
            if (Schema::hasColumn('reports', 'job_id')) {
                $table->dropForeign(['job_id']);
                $table->dropColumn('job_id');
            }

            // Add new columns if they don't exist
            if (!Schema::hasColumn('reports', 'job_posting_id')) {
                $table->foreignId('job_posting_id')->after('user_id')->constrained()->onDelete('cascade');
            }

            if (!Schema::hasColumn('reports', 'description')) {
                $table->text('description')->after('reason');
            }

            if (!Schema::hasColumn('reports', 'admin_note')) {
                $table->text('admin_note')->nullable()->after('status');
            }

            if (!Schema::hasColumn('reports', 'reviewed_by')) {
                $table->foreignId('reviewed_by')->nullable()->after('admin_note')->constrained('users')->onDelete('set null');
            }

            if (!Schema::hasColumn('reports', 'reviewed_at')) {
                $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
            }

            // Update status enum if needed
            DB::statement("ALTER TABLE reports MODIFY COLUMN status ENUM('pending', 'reviewing', 'resolved', 'rejected') DEFAULT 'pending'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn(['description', 'admin_note', 'reviewed_by', 'reviewed_at']);
        });
    }
};

