@php($plugins = config('adminpanel.plugins', []))
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', config('app.name'))</title>

@if(data_get($plugins, 'font_source_sans.enabled'))
<link rel="stylesheet" href="{{ data_get($plugins, 'font_source_sans.css') }}">
@endif
@if(data_get($plugins, 'bootstrap_icons.enabled'))
<link rel="stylesheet" href="{{ data_get($plugins, 'bootstrap_icons.css') }}">
@endif
@if(data_get($plugins, 'fontawesome.enabled'))
<link rel="stylesheet" href="{{ data_get($plugins, 'fontawesome.css') }}">
@endif
@if(data_get($plugins, 'overlayscrollbars.enabled'))
<link rel="stylesheet" href="{{ data_get($plugins, 'overlayscrollbars.css') }}">
@endif

<link rel="stylesheet" href="{{ asset('adminlte4/css/adminlte.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte4/css/custom-admin.css') }}">

@stack('css')
@yield('css')
