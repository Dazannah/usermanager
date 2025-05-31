<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\AccountAuthorizationLevel;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('account_authorization_levels', function (Blueprint $table) {
            $table->id();
            $table->string('technicalName');
            $table->string('displayName');
            $table->string('ldap_group_name');
            $table->integer('auth_level');
        });

        AccountAuthorizationLevel::create(['technicalName' => 'base', 'displayName' => 'alap', 'ldap_group_name' => 'JogosultsagigenyAlap', 'auth_level' => 1]);
        AccountAuthorizationLevel::create(['technicalName' => 'authorizer', 'displayName' => 'engedélyező', 'ldap_group_name' => 'JogosultsagigenyEngedelyezok', 'auth_level' => 2]);
        AccountAuthorizationLevel::create(['technicalName' => 'reqAdmin', 'displayName' => 'adminisztrátor', 'ldap_group_name' => 'JogosultsagigenyAdminisztrator', 'auth_level' => 4]);
        AccountAuthorizationLevel::create(['technicalName' => 'dlHandler', 'displayName' => 'terjesztési lista kezelő', 'ldap_group_name' => 'JogosultsagigenyTerjesztesilista', 'auth_level' => 8]);
        AccountAuthorizationLevel::create(['technicalName' => 'sysAdmin', 'displayName' => 'rendszergazda', 'ldap_group_name' => 'JogosultsagigenyRendszergazda', 'auth_level' => 31]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('account_authorization_levels');
    }
};
