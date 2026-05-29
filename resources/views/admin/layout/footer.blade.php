@php($layout = config('adminpanel.layout', []))
<footer class="app-footer">
    <strong>
        Copyright &copy; {{ date('Y') }}
        <a href="{{ url('/') }}" class="text-decoration-none">{{ config('app.name') }}</a>.
    </strong>
    {{ data_get($layout, 'footer_text', 'All rights reserved.') }}
</footer>
