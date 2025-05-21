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
            $table->enum('status', ['approved', 'pending', 'cancel', 'failed']);
            $table->string('order_id')->unique();
            $table->string('snap_token')->nullable();
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
