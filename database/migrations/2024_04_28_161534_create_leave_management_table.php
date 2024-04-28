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
        Schema::create('leave_management', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('employee_id');
            $table->foreignId('leave_category_id');
            $table->text('description');
            $table->text('remarks')->nullable();
            $table->enum('status', ['1', '2', '3'])->default('1')->comment('1 = pending, 2 = approved, 3 = rejected');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_management');
    }
};
