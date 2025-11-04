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
        Schema::disableForeignKeyConstraints();

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_type_id')->constrained();
            $table->foreignId('area_id')->nullable()->constrained();
            $table->foreignId('grave_id')->nullable()->constrained();
            $table->foreignId('service_id')->constrained();
            $table->foreignId('customer_id')->nullable()->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('work_type_id')->nullable()->constrained();
            $table->dateTime('work_date')->useCurrent();
            $table->decimal('hours', 5, 2);
            $table->decimal('break_hours', 5, 2)->default(0.00);
            $table->text('comment')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
