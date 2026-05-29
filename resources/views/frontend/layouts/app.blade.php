<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ \App\Models\Setting::getValue('site_name', config('app.name')) }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('branding/logo-mark.svg') }}">
    <link rel="shortcut icon" href="{{ asset('branding/logo-mark.svg') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css'])
</head>
<body>
    @include('admin.partials.flash')
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"><div class="container"><a class="navbar-brand" href="{{ route('home') }}">{{ \App\Models\Setting::getValue('site_name', 'Event Orbit') }}</a><button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button><div id="nav" class="collapse navbar-collapse"><ul class="navbar-nav ms-auto"><li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>@auth<li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a></li>@else<li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>@endauth</ul></div></div></nav>
    @yield('content')
    <footer class="bg-light border-top mt-5 py-4"><div class="container text-center"><div class="mb-2">{{ \App\Models\Setting::getValue('site_address', 'Your address') }}</div><div><a href="{{ \App\Models\Setting::getValue('facebook_url', '#') }}" class="me-2"><i class="fab fa-facebook"></i></a><a href="{{ \App\Models\Setting::getValue('instagram_url', '#') }}" class="me-2"><i class="fab fa-instagram"></i></a><a href="{{ \App\Models\Setting::getValue('x_url', '#') }}" class="me-2"><i class="fab fa-x-twitter"></i></a><a href="{{ \App\Models\Setting::getValue('linkedin_url', '#') }}"><i class="fab fa-linkedin"></i></a></div></div></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/js/app.js'])
</body>
</html>
