<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->text("departmentNumber");
            $table->text("departmentNumber2");
            $table->foreignId("location_id")->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('departments');
    }
};
