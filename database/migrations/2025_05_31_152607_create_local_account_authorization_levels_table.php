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
            $table->string('name');
            $table->string('displayName');
            $table->string('ldap_group_name');
        });

        AccountAuthorizationLevel::create(['name' => 'base', 'displayName' => 'alap', 'ldap_group_name' => 'JogosultsagigenyAlap']);
        AccountAuthorizationLevel::create(['name' => 'authorizer', 'displayName' => 'engedélyező', 'ldap_group_name' => 'JogosultsagigenyEngedelyezok']);
        AccountAuthorizationLevel::create(['name' => 'reqAdmin', 'displayName' => 'adminisztrátor', 'ldap_group_name' => 'JogosultsagigenyAdminisztrator']);
        AccountAuthorizationLevel::create(['name' => 'dlHandler', 'displayName' => 'terjesztési lista kezelő', 'ldap_group_name' => 'JogosultsagigenyTerjesztesilista']);
        AccountAuthorizationLevel::create(['name' => 'sysAdmin', 'displayName' => 'rendszergazda', 'ldap_group_name' => 'JogosultsagigenyRendszergazda']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('account_authorization_levels');
    }
};
