<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'site_name' => ['nullable', 'string', 'max:120'],
            'site_email' => ['nullable', 'email', 'max:120'],
            'site_phone' => ['nullable', 'string', 'max:40'],
            'site_address' => ['nullable', 'string', 'max:255'],
            'facebook_url' => ['nullable', 'url'],
            'instagram_url' => ['nullable', 'url'],
            'x_url' => ['nullable', 'url'],
            'linkedin_url' => ['nullable', 'url'],
            'smtp_host' => ['nullable', 'string', 'max:120'],
            'smtp_port' => ['nullable', 'string', 'max:10'],
            'smtp_username' => ['nullable', 'string', 'max:120'],
            'smtp_password' => ['nullable', 'string', 'max:120'],
            'smtp_encryption' => ['nullable', 'string', 'max:20'],
            'firebase_api_key' => ['nullable', 'string', 'max:255'],
            'firebase_project_id' => ['nullable', 'string', 'max:120'],
            'firebase_sender_id' => ['nullable', 'string', 'max:120'],
            'onesignal_app_id' => ['nullable', 'string', 'max:255'],
            'onesignal_rest_api_key' => ['nullable', 'string', 'max:255'],
            'google_map_api_key' => ['nullable', 'string', 'max:255'],
            'google_map_embed_url' => ['nullable', 'url'],
            'contact_email' => ['nullable', 'email', 'max:120'],
            'contact_phone' => ['nullable', 'string', 'max:40'],
            'contact_whatsapp' => ['nullable', 'string', 'max:40'],
        ];
    }
}

