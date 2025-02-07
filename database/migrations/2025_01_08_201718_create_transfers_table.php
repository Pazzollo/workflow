<?php

use App\Models\Company;
use App\Models\TransferType;
use App\Models\User;
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
            $table->decimal('ammount',8 , 2);
            $table->foreignIdFor(Company::class);
            $table->foreignIdFor(TransferType::class);
            $table->date('transfer_date');
            $table->foreignIdFor(User::class);
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
