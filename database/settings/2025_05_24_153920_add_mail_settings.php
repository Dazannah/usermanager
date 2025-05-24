<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void {
        $this->migrator->add('mail.host', null);
        $this->migrator->add('mail.port', null);
        $this->migrator->add('mail.username', null);
        $this->migrator->addEncrypted('mail.password', null);
    }

    public function down(): void {
        $this->migrator->delete('mail.host');
        $this->migrator->delete('mail.port');
        $this->migrator->delete('mail.username');
        $this->migrator->delete('mail.password');
    }
};
