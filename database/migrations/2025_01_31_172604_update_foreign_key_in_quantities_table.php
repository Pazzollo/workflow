<?php

use App\Models\Company;
use App\Models\Supplier;
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
        Schema::table('quantities', function (Blueprint $table) {
            // Uklonite postojeći strani ključ
            $table->dropForeign(['supplier_id']);
            $table->dropColumn('supplier_id');

            // Dodajte novi strani ključ
            $table->foreignIdFor(App\Models\Company::class)->constrained()->after('material_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quantities', function (Blueprint $table) {
            // Uklonite novi strani ključ
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');

            // Dodajte stari strani ključ
            $table->foreignIdFor(App\Models\Supplier::class)->constrained()->after('material_id');
        });
    }
};
