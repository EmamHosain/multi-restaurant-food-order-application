<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('client_id')->nullable();
            // $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');


            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('currency')->nullable();
            $table->float('amount', 8, 2);
            $table->float('total_amount', 8, 2);
            $table->string('order_number')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('order_date')->nullable();
            $table->string('order_month')->nullable();
            $table->string('order_year')->nullable();
            $table->string('confirmed_date')->nullable();
            $table->string('processing_date')->nullable();
            $table->string('shipped_date')->nullable();
            $table->string('delivered_date')->nullable();

            $table->enum('status', [
                'Processing',
                'Deliverd',
                'Confirmed',
                'Pending'
            ]);
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
