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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();

            $table->string('description')->nullable();
            $table->decimal('ammount', 8, 2);
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('transfer_type_id')->constrained()->cascadeOnDelete();
            $table->date('transfer_date');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->smallInteger('transfer_doughter_id')->nullable();
            $table->smallInteger('deleted')->default(0);
            $table->smallInteger('deleted_by')->nullable();
            $table->smallInteger('status')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
