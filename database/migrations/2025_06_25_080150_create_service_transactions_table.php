<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('service_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->nullable();
            $table->string('contact')->nullable();
            $table->unsignedBigInteger('transaction_log_id');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('cash', 10, 2);
            $table->decimal('change', 10, 2)->default(0);
            $table->string('ss_number');
            $table->string('or_number')->nullable();
            $table->string('status')->default('completed'); // completed, refunded, voided
            $table->string('reason')->nullable();
            $table->unsignedBigInteger('branch_id')->default(1);
            $table->timestamps();

            $table->foreign('transaction_log_id')
                  ->references('id')->on('transaction_logs')
                  ->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('service_transactions');
    }
};
