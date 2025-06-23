<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branch_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->unique(); // ID from external API
            $table->string('status')->default('Inactive'); // Can be 'Active', 'Inactive', etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branch_statuses');
    }
};
