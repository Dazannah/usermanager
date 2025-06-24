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
            $table->string('department_leader')->nullable();

            $table->string('note')->nullable();
            $table->string('technical_note')->nullable();

            $table->foreignId("worker_request_status_id")->constrained();
            $table->foreignId("worker_request_process_id")->constrained();

            $table->foreignId("requester_id")->constrained("users");
            $table->timestamp("requested");

            $table->foreignId("reviewer_id")->nullable()->constrained("users");
            $table->timestamp("reviewed")->nullable();

            $table->foreignId("creator_id")->nullable()->constrained("users");
            $table->timestamp("created")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('worker_requests');
    }
};
