<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->text("displayName");
            $table->text("note")->nullable();
            $table->foreignId("status_id")->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('locations');
    }
};
