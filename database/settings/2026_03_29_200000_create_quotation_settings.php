<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // Quotation settings
        $this->migrator->add('quotations.enabled', true);
        $this->migrator->add('quotations.quote_id_prefix', 'QT-');
        $this->migrator->add('quotations.default_validity_days', 7);
        $this->migrator->add('quotations.min_validity_days', 1);
        $this->migrator->add('quotations.max_validity_days', 30);
        $this->migrator->add('quotations.allow_guest_quotes', true);
        $this->migrator->add('quotations.require_phone', true);
        $this->migrator->add('quotations.auto_expire_enabled', true);
        $this->migrator->add('quotations.admin_notification_email', null);
        $this->migrator->add('quotations.default_customer_note', 'Thank you for your interest in Sheffield Africa. Please review this quotation and let us know if you have any questions. Once you are happy, go ahead and accept it through your portal and we will get things moving right away.');
    }
};
