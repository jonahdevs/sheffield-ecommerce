<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void
    {

        $this->migrator->add('general.store_name', 'Sheffield Africa');
        $this->migrator->add('general.store_tagline', null);
        $this->migrator->add('general.store_logo', null);
        $this->migrator->add('general.store_favicon', null);
        $this->migrator->add('general.store_email', null);
        $this->migrator->add('general.store_phone', '+254 713 777 111');
        $this->migrator->add('general.store_address', 'Off Old Mombasa Road before the Nairobi SGR Terminus');
        $this->migrator->add('general.store_address_line_2', 'Petrocity Complex 1st Floor-Off Links Road, Nyali, Mombasa');
        $this->migrator->add('general.store_city', null);
        $this->migrator->add('general.store_state', null);
        $this->migrator->add('general.store_postal_code', null);
        $this->migrator->add('general.store_country', 'Kenya');
    }
};
