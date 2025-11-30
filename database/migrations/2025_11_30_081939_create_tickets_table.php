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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();

            $table->string('subject');
            $table->string('message');

            $table->enum('status', ['new', 'in_progress', 'processed'])->default('new');

            $table->text('manager_reply')->nullable();
            $table->timestamp('manager_reply_date')->nullable();

            $table->foreignId('manager_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
