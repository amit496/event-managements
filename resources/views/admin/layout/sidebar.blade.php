@php($menu = config('adminpanel.menu', []))
@php($brand = config('adminpanel.brand', []))
@php($layout = config('adminpanel.layout', []))
@php($groupLabels = ['main' => 'Main', 'catalog' => 'Catalog', 'finance' => 'Finance', 'access' => 'Access Control', 'system' => 'System'])
@php($groupedMenu = collect($menu)->groupBy(fn (array $item): string => data_get($item, 'type', 'main')))

<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="{{ data_get($layout, 'sidebar_theme', 'dark') }}">
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img src="{{ asset(data_get($brand, 'logo', 'adminlte4/assets/img/AdminLTELogo.png')) }}" alt="Admin" class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">{{ data_get($brand, 'label', config('app.name')) }}</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" data-accordion="false">
                @foreach($groupedMenu as $type => $items)
                    <li class="nav-header text-uppercase">{{ data_get($groupLabels, $type, ucfirst($type)) }}</li>
                    @foreach($items as $item)
                        @php($active = request()->routeIs(data_get($item, 'pattern', '')))
                        <li class="nav-item">
                            <a href="{{ route(data_get($item, 'route')) }}" class="nav-link {{ $active ? 'active' : '' }}">
                                <i class="nav-icon {{ data_get($item, 'icon', 'fas fa-circle') }}"></i>
                                <p>{{ data_get($item, 'label', 'Menu') }}</p>
                            </a>
                        </li>
                    @endforeach
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
