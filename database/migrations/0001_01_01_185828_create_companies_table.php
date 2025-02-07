<?php

use App\Models\CompanyRole;
use App\Models\Status;
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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('address');
            $table->string('city');
            $table->foreignIdFor(Status::class)->constrained();
            $table->foreignIdFor(CompanyRole::class)->constrained();
            $table->unsignedInteger('pib');
            $table->unsignedInteger('mbr');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
