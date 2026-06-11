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
        // Add status column to merchant_products table
        Schema::table('merchant_products', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('is_active');
        });

        // Create merchant_payouts table for payout history
        Schema::create('merchant_payouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // the merchant
            $table->unsignedBigInteger('admin_id')->nullable(); // admin who paid
            $table->decimal('amount', 12, 2);
            $table->string('note')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('merchant_products', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::dropIfExists('merchant_payouts');
    }
};
