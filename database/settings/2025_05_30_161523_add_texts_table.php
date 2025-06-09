<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void {
        $this->migrator->add('texts.departmentNumber', 'Osztály száma');
        $this->migrator->add('texts.departmentNumber2', 'Másodlagos osztály száma');
    }

    public function down(): void {
        $this->migrator->delete('texts.departmentNumber');
        $this->migrator->delete('texts.departmentNumber2');
    }
};
