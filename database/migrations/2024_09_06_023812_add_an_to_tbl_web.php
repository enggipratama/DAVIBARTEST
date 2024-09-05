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
        Schema::table('tbl_web', function (Blueprint $table) {
            $table->string('web_bca_an')->nullable();
            $table->string('web_bri_an')->nullable();
            $table->string('web_mandiri_an')->nullable();
            $table->string('web_ewallet_an')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_web', function (Blueprint $table) {
            $table->dropColumn('web_bca_an');
            $table->dropColumn('web_bri_an');
            $table->dropColumn('web_mandiri_an');
            $table->dropColumn('web_ewallet_an');
        });
    }
};
