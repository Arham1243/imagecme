<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title . ' | ' . env('APP_NAME') : env('APP_NAME') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.layouts.links')
    @yield('css')
    @stack('css')
</head>

@php
    $menuItemsInit = config('admin_sidebar');
    $menuItems = collect($menuItemsInit)->map(function ($item) {
        if (isset($item['route'])) {
            $item['route'] = is_array($item['route'])
                ? route($item['route'][0], $item['route'][1] ?? [])
                : route($item['route']);
        } else {
            $item['route'] = '#';
        }

        if (isset($item['submenu'])) {
            $item['submenu'] = collect($item['submenu'])
                ->map(function ($subItem) {
                    $subItem['route'] = is_array($subItem['route'])
                        ? route($subItem['route'][0], $subItem['route'][1] ?? [])
                        : route($subItem['route']);
                    return $subItem;
                })
                ->toArray();
        }

        return $item;
    });
@endphp

<body class="responsive">
    <div class="dashboard">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-md-2">
                    @include('admin.layouts.sidebar')
                </div>
                <div class="col-md-10">
                    <div class="row g-0">
                        <div class="col-12">
                            @include('admin.layouts.header')
                        </div>
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="loader-mask" id="loader">
        <div class="loader"></div>
    </div>

    @include('admin.layouts.scripts')
    @yield('js')
    @stack('js')
    <script type="text/javascript">
        const MENU_ITEMS = @json($menuItems);

        document.getElementById('globalSearch').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const resultsContainer = document.querySelector('.search-results__values');
            resultsContainer.innerHTML = '';
            if (searchTerm.length === 0) return;

            const filteredMenuItems = MENU_ITEMS.filter(item => {

                if (item.title.toLowerCase() === 'logout') {
                    return false;
                }
                const matchesMainItem = item.title.toLowerCase().includes(searchTerm);
                const filteredSubmenu = item.submenu?.filter(subItem => subItem.title.toLowerCase()
                    .includes(searchTerm));
                return matchesMainItem || (filteredSubmenu && filteredSubmenu.length > 0);
            });
            filteredMenuItems.forEach(item => {
                const li = document.createElement('li');
                const a = document.createElement('a');
                a.href = item.route;
                a.textContent = item.title;

                li.appendChild(a);
                resultsContainer.appendChild(li);
                if (item.submenu) {
                    const filteredSubmenu = item.submenu.filter(subItem => subItem.title.toLowerCase()
                        .includes(searchTerm));
                    filteredSubmenu.forEach(subItem => {
                        const subLi = document.createElement('li');
                        const subA = document.createElement('a');
                        subA.href = subItem.route;
                        subA.textContent = '→ ' + subItem.title;
                        subLi.appendChild(subA);
                        resultsContainer.appendChild(subLi);
                    });
                }
            });
        });
        (() => {
            @if (session('notify_success'))
                $.toast({
                    heading: 'Success!',
                    position: 'bottom-right',
                    text: '{{ session('notify_success') }}',
                    loaderBg: '#ff6849',
                    icon: 'success',
                    hideAfter: 2000,
                    stack: 6
                });
            @elseif (session('notify_error'))
                $.toast({
                    heading: 'Error!',
                    position: 'bottom-right',
                    text: '{{ session('notify_error') }}',
                    loaderBg: '#ff6849',
                    icon: 'error',
                    hideAfter: 5000,
                    stack: 6
                });
            @endif
        })()
    </script>
</body>

</html>
