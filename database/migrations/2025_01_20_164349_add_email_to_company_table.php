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
        Schema::table('Companies', function (Blueprint $table) {
            $table->string('email1')->nullable();
            $table->string('email2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Companies', function (Blueprint $table) {
            $table->dropColumn('email1');
            $table->dropColumn('email2');
        });
    }
};
