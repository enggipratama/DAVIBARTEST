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
            $table->string('web_bca')->nullable();
            $table->string('web_bri')->nullable();
            $table->string('web_mandiri')->nullable();
            $table->string('web_ewallet')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_web', function (Blueprint $table) {
            $table->dropColumn('web_bca');
            $table->dropColumn('web_bri');
            $table->dropColumn('web_mandiri');
            $table->dropColumn('web_ewallet');
        });
    }
};
