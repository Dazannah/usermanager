<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void {
        $this->migrator->add('app.app_name', 'Felhasználó kezelő');
        $this->migrator->add('app.logo_name', null);
    }

    public function down(): void {
        $this->migrator->delete('app.app_name');
        $this->migrator->delete('app.logo_name');
    }
};
