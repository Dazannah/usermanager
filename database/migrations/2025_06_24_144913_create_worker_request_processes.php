<?php

use App\Models\WorkerRequestProcess;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('worker_request_processes', function (Blueprint $table) {
            $table->id();
            $table->text("name");
            $table->text("displayName");
        });

        WorkerRequestProcess::create([
            'name' => 'new',
            'displayName' => 'Új dolgozó'
        ]);

        WorkerRequestProcess::create([
            'name' => 'modify',
            'displayName' => 'Módosítás'
        ]);

        WorkerRequestProcess::create([
            'name' => 'delete',
            'displayName' => 'Törlés'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('worker_request_processes');
    }
};
