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
        $this->migrator->delete('ldap.active');
        $this->migrator->delete('ldap.host');
        $this->migrator->delete('ldap.base_dn');
        $this->migrator->delete('ldap.port');
        $this->migrator->delete('ldap.username');
        $this->migrator->delete('ldap.password');
    }
};
