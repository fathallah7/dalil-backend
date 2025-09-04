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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['paid', 'unpaid', 'partial', 'canceled'])->default('unpaid');
            $table->timestamps();

            // Foreign key constraints
            $table->foreignId('membership_id')->nullable()->constrained('memberships')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_invoices');
    }
};
