<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void {
        $this->migrator->add('ldap.active', false);
        $this->migrator->add('ldap.host', null);
        $this->migrator->add('ldap.base_dn', null);
        $this->migrator->add('ldap.port', null);
        $this->migrator->add('ldap.username', null);
        $this->migrator->addEncrypted('ldap.password', null);
    }

    public function down(): void {
        $this->migrator->delete('ldap.active', false);
        $this->migrator->delete('ldap.host', null);
        $this->migrator->delete('ldap.base_dn', null);
        $this->migrator->delete('ldap.port', null);
        $this->migrator->delete('ldap.username', null);
        $this->migrator->delete('ldap.password', null);
    }
};
