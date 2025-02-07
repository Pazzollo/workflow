<?php

use App\Models\Finish;
use App\Models\Materialtype;
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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Materialtype::class)->constrained(); //materialtype_id
            $table->string('brand');
            $table->foreignIdFor(Finish::class)->constrained(); //finish_id
            $table->unsignedInteger('width');
            $table->unsignedInteger('length');
            $table->string('dimension_name')->nullable();
            $table->unsignedInteger('weight');
            $table->string('tickness')->nullable();
            $table->string('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
