<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transaction_logs', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number')->nullable(); // auto-generated
            $table->string('or_number')->nullable(); // Official Receipt number
            $table->unsignedBigInteger('branch_id');
            $table->string('status'); // e.g., 'void', 'refund'
            $table->string('reason')->nullable();
            $table->string('item_name');
            $table->decimal('item_rate', 10, 2);
            $table->integer('quantity');
            $table->string('staff_name')->nullable();
            $table->string('ss_number');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('transaction_logs');
    }
};
