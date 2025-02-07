<?php

use App\Models\Dimension;
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
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('width');
            $table->dropColumn('length');
            $table->dropColumn('dimension_name');
            $table->foreignIdFor(Dimension::class)->constrained()->after('finish_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->integer('width');
            $table->integer('length');
            $table->string('dimension_name');
            $table->dropForeign(['dimension_id']);
            $table->dropColumn('dimension_id');
        });
    }
};
