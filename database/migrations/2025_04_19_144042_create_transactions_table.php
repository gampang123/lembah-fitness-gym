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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->foreignId('package_id')->nullable()->constrained('packages')->nullOnDelete();
            $table->enum('payment_method', ['cash', 'online_payment']);
            $table->enum('status', [ 'paid', 'pending', 'cancelled', 'expired']);
            $table->string('midtrans_order_id')->unique()->nullable(); // Unique order ID for Midtrans
            $table->string('midtrans_snap_token')->nullable(); // For storing Midtrans snap token
            $table->string('midtrans_redirect_url')->nullable(); // For Midtrans Redirect URL
            $table->string('midtrans_payment_type')->nullable(); // For storing Midtrans payment type
            $table->string('midtrans_status')->nullable(); // For storing Midtrans status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
