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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 100)->unique();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled', 'refunded'])->default('pending');
            $table->decimal('total_amount', 10, 2);
            $table->text('shipping_address');
            $table->text('billing_address');
            $table->string('payment_method', 50);
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('shipping_method', 50);
            $table->decimal('shipping_cost', 10, 2)->default(0.00);
            $table->string('tracking_number', 100)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
