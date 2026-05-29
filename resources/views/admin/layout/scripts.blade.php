@php($plugins = config('adminpanel.plugins', []))

@if(data_get($plugins, 'bootstrap_bundle.enabled'))
<script src="{{ data_get($plugins, 'bootstrap_bundle.js') }}"></script>
@endif
@if(data_get($plugins, 'overlayscrollbars.enabled'))
<script src="{{ data_get($plugins, 'overlayscrollbars.js') }}"></script>
@endif
<script src="{{ asset('adminlte4/js/adminlte.min.js') }}"></script>

@if(data_get($plugins, 'overlayscrollbars.enabled'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector('.sidebar-wrapper');

        if (sidebarWrapper && window.OverlayScrollbarsGlobal?.OverlayScrollbars) {
            window.OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                scrollbars: {
                    theme: 'os-theme-light',
                    autoHide: 'leave',
                    clickScroll: true,
                },
            });
        }
    });
</script>
@endif

@stack('js')
@yield('js')
