<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Event Orbit', 'group' => 'general', 'type' => 'text'],
            ['key' => 'site_email', 'value' => 'info@eventorbit.local', 'group' => 'general', 'type' => 'email'],
            ['key' => 'site_phone', 'value' => '+1-202-555-0115', 'group' => 'general', 'type' => 'text'],
            ['key' => 'site_address', 'value' => '221B Event Street, Downtown, New York, NY 10001', 'group' => 'general', 'type' => 'text'],

            ['key' => 'facebook_url', 'value' => 'https://facebook.com/eventorbit', 'group' => 'social', 'type' => 'url'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/eventorbit', 'group' => 'social', 'type' => 'url'],
            ['key' => 'x_url', 'value' => 'https://x.com/eventorbit', 'group' => 'social', 'type' => 'url'],
            ['key' => 'linkedin_url', 'value' => 'https://linkedin.com/company/eventorbit', 'group' => 'social', 'type' => 'url'],

            ['key' => 'smtp_host', 'value' => 'smtp.mailtrap.io', 'group' => 'smtp', 'type' => 'text'],
            ['key' => 'smtp_port', 'value' => '2525', 'group' => 'smtp', 'type' => 'text'],
            ['key' => 'smtp_username', 'value' => 'event_orbit_user', 'group' => 'smtp', 'type' => 'text'],
            ['key' => 'smtp_password', 'value' => 'event_orbit_password', 'group' => 'smtp', 'type' => 'text'],
            ['key' => 'smtp_encryption', 'value' => 'tls', 'group' => 'smtp', 'type' => 'text'],

            ['key' => 'firebase_api_key', 'value' => 'AIzaSyDummyFirebaseApiKey123456', 'group' => 'firebase', 'type' => 'text'],
            ['key' => 'firebase_project_id', 'value' => 'event-orbit-project', 'group' => 'firebase', 'type' => 'text'],
            ['key' => 'firebase_sender_id', 'value' => '123456789012', 'group' => 'firebase', 'type' => 'text'],

            ['key' => 'onesignal_app_id', 'value' => '11111111-2222-3333-4444-555555555555', 'group' => 'onesignal', 'type' => 'text'],
            ['key' => 'onesignal_rest_api_key', 'value' => 'onesignal_rest_api_dummy_key_123456', 'group' => 'onesignal', 'type' => 'text'],

            ['key' => 'google_map_api_key', 'value' => 'AIzaSyDummyGoogleMapKey123456', 'group' => 'google-map', 'type' => 'text'],
            ['key' => 'google_map_embed_url', 'value' => 'https://www.google.com/maps?q=Times+Square+New+York&output=embed', 'group' => 'google-map', 'type' => 'url'],

            ['key' => 'contact_email', 'value' => 'support@eventorbit.local', 'group' => 'contact', 'type' => 'email'],
            ['key' => 'contact_phone', 'value' => '+1-202-555-0177', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'contact_whatsapp', 'value' => '+1-202-555-0199', 'group' => 'contact', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            Setting::query()->updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'group' => $setting['group'],
                    'type' => $setting['type'],
                ]
            );
        }
    }
}
