<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('sub_auth_item_worker_request', function (Blueprint $table) {
            $table->id();
            $table->foreignId("sub_auth_item_id")->constrained();
            $table->foreignId("worker_request_id")->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('sub_auth_item_worker_request');
    }
};
