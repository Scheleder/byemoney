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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->foreignId('creditor_id')->constrained();
            $table->foreignId('user_id')->constrained()->nullable();
            $table->foreignId('mean_payment_id')->constrained()->nullable();
            $table->decimal('value', 10,2)->default('0.00');
            $table->dateTime('due_date')->useCurrent = true;
            $table->dateTime('paid_date')->useCurrent = true;
            $table->string('barcode',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
