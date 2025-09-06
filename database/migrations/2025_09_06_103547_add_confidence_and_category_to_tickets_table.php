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
        Schema::table('tickets', function (Blueprint $table) {
            $table->decimal('confidence', 3, 2)->default(0.0);
            $table->enum('category', ['Technical', 'Payments', 'Inquiries', 'Feedback', 'Appointment'])
                ->default('Inquiries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn(['confidence', 'category']);
        });
    }
};
