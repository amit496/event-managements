<!doctype html>
<html lang="en">
<head>
    @include('admin.layout.head')
</head>
<body class="{{ config('adminpanel.layout.body_class', 'layout-fixed sidebar-expand-lg bg-body-tertiary') }}">
<div class="app-wrapper">
    @include('admin.layout.header')
    @include('admin.layout.sidebar')

    <main class="app-main">
        @hasSection('content_header')
            <div class="app-content-header">
                <div class="container-fluid">
                    @yield('content_header')
                </div>
            </div>
        @endif

        <div class="app-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </main>

    @include('admin.layout.footer')
</div>

@include('admin.layout.scripts')
</body>
</html>
