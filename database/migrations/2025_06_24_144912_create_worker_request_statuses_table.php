<?php

use App\Models\WorkerRequestStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('worker_request_statuses', function (Blueprint $table) {
            $table->id();
            $table->text("name");
            $table->text("displayName");
        });

        WorkerRequestStatus::create([
            'name' => 'requested',
            'displayName' => 'Igényelt'
        ]);

        WorkerRequestStatus::create([
            'name' => 'allowed',
            'displayName' => 'Engedélyezett'
        ]);

        WorkerRequestStatus::create([
            'name' => 'rejected',
            'displayName' => 'Elutasított'
        ]);

        WorkerRequestStatus::create([
            'name' => 'deficiency',
            'displayName' => 'Pótlás'
        ]);

        WorkerRequestStatus::create([
            'name' => 'done',
            'displayName' => 'Elkészűlt'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('worker_request_statuses');
    }
};
