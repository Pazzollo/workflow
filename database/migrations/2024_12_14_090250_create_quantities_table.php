<?php

use App\Models\Supplier;
use App\Models\Transfer;
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
        Schema::create('quantities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('material_id')->constrained();
            $table->integer('quantity');
            $table->enum('transfer', Transfer::$category);
            $table->string('description')->nullable();
            $table->foreignIdFor(Supplier::class)->constrained();
            $table->string('measure')->default('tabaka');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quantities');
    }
};
