<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void {
        $this->migrator->add('app.app_name', 'Felhasználó kezelő');
        $this->migrator->add('app.logo_name', null);
        $this->migrator->add('app.primary_color', '15808a');
        $this->migrator->add('app.secondary_color', 'e3a420');
    }

    public function down(): void {
        $this->migrator->delete('app.app_name');
        $this->migrator->delete('app.logo_name');
        $this->migrator->delete('app.primary_color');
        $this->migrator->delete('app.secondary_color');
    }
};
