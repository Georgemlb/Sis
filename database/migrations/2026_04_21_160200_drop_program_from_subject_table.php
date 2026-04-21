<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('subject', 'program')) {
            return;
        }

        try {
            Schema::table('subject', function (Blueprint $table) {
                $table->dropForeign(['program']);
            });
        } catch (QueryException $exception) {
            // Ignore missing foreign key to support already-modified databases.
        }

        Schema::table('subject', function (Blueprint $table) {
            $table->dropColumn('program');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('subject', 'program')) {
            return;
        }

        Schema::table('subject', function (Blueprint $table) {
            $table->foreignId('program')->nullable()->constrained('program', 'program_id');
        });
    }
};
