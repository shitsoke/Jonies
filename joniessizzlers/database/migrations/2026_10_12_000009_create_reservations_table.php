<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();
            $table->string('customer_name');
            $table->string('contact_number');
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->date('reservation_date');
            $table->time('reservation_time');
            $table->unsignedTinyInteger('guest_count');
            $table->text('additional_requests')->nullable();
            $table->string('status')->default('pending');
            $table->boolean('policy_accepted')->default(false);
            $table->timestamp('policy_accepted_at')->nullable();
            $table->foreignId('processed_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('processed_at')->nullable();
            $table->text('decline_reason')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();

            $table->index(['branch_id', 'reservation_date', 'reservation_time']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
