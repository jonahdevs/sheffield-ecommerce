<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void
    {
        $this->migrator->add('social.facebook_url', 'https://www.facebook.com/SheffieldAfricaFacilitySolutions');
        $this->migrator->add('social.instagram_url', 'https://www.instagram.com/sheffieldafrica/');
        $this->migrator->add('social.twitter_url', 'https://twitter.com/sheffield_afric/');
        $this->migrator->add('social.tiktok_url', 'http://tiktok.com/@sheffieldafrica');
        $this->migrator->add('social.youtube_url', 'https://www.youtube.com/channel/UCK-oWPdQazenIHndl4zABew');
        $this->migrator->add('social.linkedin_url', 'https://www.linkedin.com/company/sheffield-steel-systems-ltd/mycompany');
        $this->migrator->add('social.whatsapp_number', '254114838130');
    }
};
