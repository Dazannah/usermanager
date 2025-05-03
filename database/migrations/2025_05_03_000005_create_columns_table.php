<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('columns', function (Blueprint $table) {
            $table->id();
            $table->text("displayName");
            $table->foreignId("status_id")->constrained();
            $table->integer("position");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('columns');
    }
};
