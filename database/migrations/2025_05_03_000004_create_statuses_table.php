<?php

use App\Models\Status;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->text("name");
            $table->text("displayName");
        });

        Status::create([
            'name' => 'active',
            'displayName' => 'Aktív'
        ]);

        Status::create([
            'name' => 'inactive',
            'displayName' => 'Inaktív'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('statuses');
    }
};
