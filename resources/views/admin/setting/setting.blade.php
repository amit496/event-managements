@extends('admin.layout.app')
@section('title', 'Settings')
@section('content')
@include('admin.partials.flash')
@include('admin.setting.breadcrumb')

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            @method('PUT')

            <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="tab-general" data-bs-toggle="tab" href="#pane-general" role="tab">General</a></li>
                <li class="nav-item"><a class="nav-link" id="tab-social" data-bs-toggle="tab" href="#pane-social" role="tab">Social Links</a></li>
                <li class="nav-item"><a class="nav-link" id="tab-smtp" data-bs-toggle="tab" href="#pane-smtp" role="tab">SMTP</a></li>
                <li class="nav-item"><a class="nav-link" id="tab-firebase" data-bs-toggle="tab" href="#pane-firebase" role="tab">Firebase</a></li>
                <li class="nav-item"><a class="nav-link" id="tab-onesignal" data-bs-toggle="tab" href="#pane-onesignal" role="tab">OneSignal</a></li>
                <li class="nav-item"><a class="nav-link" id="tab-map" data-bs-toggle="tab" href="#pane-map" role="tab">Map & Contact</a></li>
            </ul>

            <div class="tab-content border border-top-0 p-3" id="settingsTabContent">
                <div class="tab-pane fade show active" id="pane-general" role="tabpanel">
                    <div class="row">
                        <div class="form-group col-md-4"><label>Site Name</label><input name="site_name" value="{{ $settings['site_name'] }}" class="form-control"></div>
                        <div class="form-group col-md-4"><label>Site Email</label><input name="site_email" value="{{ $settings['site_email'] }}" class="form-control"></div>
                        <div class="form-group col-md-4"><label>Site Phone</label><input name="site_phone" value="{{ $settings['site_phone'] }}" class="form-control"></div>
                        <div class="form-group col-md-12"><label>Address</label><input name="site_address" value="{{ $settings['site_address'] }}" class="form-control"></div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pane-social" role="tabpanel">
                    <div class="row">
                        <div class="form-group col-md-6"><label>Facebook</label><input name="facebook_url" value="{{ $settings['facebook_url'] }}" class="form-control"></div>
                        <div class="form-group col-md-6"><label>Instagram</label><input name="instagram_url" value="{{ $settings['instagram_url'] }}" class="form-control"></div>
                        <div class="form-group col-md-6"><label>X</label><input name="x_url" value="{{ $settings['x_url'] }}" class="form-control"></div>
                        <div class="form-group col-md-6"><label>LinkedIn</label><input name="linkedin_url" value="{{ $settings['linkedin_url'] }}" class="form-control"></div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pane-smtp" role="tabpanel">
                    <div class="row">
                        <div class="form-group col-md-3"><label>Host</label><input name="smtp_host" value="{{ $settings['smtp_host'] }}" class="form-control"></div>
                        <div class="form-group col-md-3"><label>Port</label><input name="smtp_port" value="{{ $settings['smtp_port'] }}" class="form-control"></div>
                        <div class="form-group col-md-3"><label>Username</label><input name="smtp_username" value="{{ $settings['smtp_username'] }}" class="form-control"></div>
                        <div class="form-group col-md-3"><label>Password</label><input name="smtp_password" value="{{ $settings['smtp_password'] }}" class="form-control"></div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pane-firebase" role="tabpanel">
                    <div class="row">
                        <div class="form-group col-md-4"><label>API Key</label><input name="firebase_api_key" value="{{ $settings['firebase_api_key'] }}" class="form-control"></div>
                        <div class="form-group col-md-4"><label>Project ID</label><input name="firebase_project_id" value="{{ $settings['firebase_project_id'] }}" class="form-control"></div>
                        <div class="form-group col-md-4"><label>Sender ID</label><input name="firebase_sender_id" value="{{ $settings['firebase_sender_id'] }}" class="form-control"></div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pane-onesignal" role="tabpanel">
                    <div class="row">
                        <div class="form-group col-md-6"><label>App ID</label><input name="onesignal_app_id" value="{{ $settings['onesignal_app_id'] }}" class="form-control"></div>
                        <div class="form-group col-md-6"><label>REST API Key</label><input name="onesignal_rest_api_key" value="{{ $settings['onesignal_rest_api_key'] }}" class="form-control"></div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pane-map" role="tabpanel">
                    <div class="row">
                        <div class="form-group col-md-6"><label>Google Map API Key</label><input name="google_map_api_key" value="{{ $settings['google_map_api_key'] }}" class="form-control"></div>
                        <div class="form-group col-md-6"><label>Map Embed URL</label><input name="google_map_embed_url" value="{{ $settings['google_map_embed_url'] }}" class="form-control"></div>
                        <div class="form-group col-md-4"><label>Contact Email</label><input name="contact_email" value="{{ $settings['contact_email'] }}" class="form-control"></div>
                        <div class="form-group col-md-4"><label>Contact Phone</label><input name="contact_phone" value="{{ $settings['contact_phone'] }}" class="form-control"></div>
                        <div class="form-group col-md-4"><label>WhatsApp</label><input name="contact_whatsapp" value="{{ $settings['contact_whatsapp'] }}" class="form-control"></div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button class="btn btn-primary">Save Settings</button>
            </div>
        </form>
    </div>
</div>
@stop
@section('css') @vite(['resources/css/app.css']) @stop
@section('js') @vite(['resources/js/app.js']) @include('admin.setting.setting-js') @stop

