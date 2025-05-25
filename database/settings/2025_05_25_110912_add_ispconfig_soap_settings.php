<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void {
        $this->migrator->add('ispconfig_soap.active', false);
        $this->migrator->add('ispconfig_soap.uri', null);
        $this->migrator->add('ispconfig_soap.location', null);
        $this->migrator->add('ispconfig_soap.username', null);
        $this->migrator->addEncrypted('ispconfig_soap.password', null);
    }

    public function down(): void {
        $this->migrator->delete('ispconfig_soap.active');
        $this->migrator->delete('ispconfig_soap.uri');
        $this->migrator->delete('ispconfig_soap.location');
        $this->migrator->delete('ispconfig_soap.username');
        $this->migrator->delete('ispconfig_soap.password');
    }
};
