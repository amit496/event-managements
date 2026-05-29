<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingUpdateRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;

class SettingController extends Controller
{
    public function edit()
    {
        $keys = [
            'site_name', 'site_email', 'site_phone', 'site_address',
            'facebook_url', 'instagram_url', 'x_url', 'linkedin_url',
            'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password', 'smtp_encryption',
            'firebase_api_key', 'firebase_project_id', 'firebase_sender_id',
            'onesignal_app_id', 'onesignal_rest_api_key',
            'google_map_api_key', 'google_map_embed_url',
            'contact_email', 'contact_phone', 'contact_whatsapp',
        ];

        $settings = [];
        foreach ($keys as $key) {
            $settings[$key] = Setting::getValue($key, '');
        }

        return view('admin.setting.setting', compact('settings'));
    }

    public function update(SettingUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        foreach ($validated as $key => $value) {
            Setting::setValue($key, $value ?? '', $this->groupFor($key));
        }

        return back()->with('flash', ['type' => 'success', 'message' => 'Settings saved successfully.']);
    }

    private function groupFor(string $key): string
    {
        return match (true) {
            str_contains($key, 'smtp_') => 'smtp',
            str_contains($key, 'firebase_') => 'firebase',
            str_contains($key, 'onesignal_') => 'onesignal',
            str_contains($key, 'google_map_') => 'google-map',
            str_contains($key, 'contact_') => 'contact',
            str_contains($key, '_url') => 'social',
            default => 'general',
        };
    }
}
