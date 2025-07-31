<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('worker_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_technical')->default(false);
            $table->string('registration_number')->nullable();
            $table->string('post');
            $table->foreignId("department_id")->constrained();

            $table->string('note')->nullable();
            $table->string('technical_note')->nullable();

            $table->foreignId("worker_request_status_id")->constrained();
            $table->foreignId("worker_request_process_id")->constrained();

            $table->foreignId("requester_id")->constrained("users");
            $table->timestamp("requested_at");

            $table->foreignId("reviewer_id")->nullable()->constrained("users");
            $table->timestamp("reviewed_at")->nullable();

            $table->foreignId("closer_id")->nullable()->constrained("users");
            $table->timestamp("closed_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('worker_requests');
    }
};
