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
        $item['route'] = isset($item['route']) ? route($item['route']) : '#';

        if (isset($item['submenu'])) {
            $item['submenu'] = collect($item['submenu'])
                ->map(function ($subItem) {
                    $subItem['route'] = isset($subItem['route']) ? route($subItem['route']) : '#';
                    return $subItem;
                })
                ->toArray();
        }
        return $item;
    });
@endphp

<body class="responsive">
    <input type="hidden" id="web_base_url" value="{{ url('/') }}" />
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
        document.getElementById('globalSearch').addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            const searchResults = document.querySelector('.search-results__values');
            searchResults.innerHTML = '';

            if (query.length === 0) {
                return;
            }

            // Filter menu items
            const results = MENU_ITEMS.flatMap(item => {
                const matchedItems = [];

                if (item.title.toLowerCase().includes(query)) {
                    matchedItems.push(item);
                }

                if (item.submenu) {
                    const filteredSubmenu = item.submenu.filter(sub => sub.title.toLowerCase()
                        .includes(
                            query));
                    matchedItems.push(...filteredSubmenu);
                }

                return matchedItems;
            });

            // Display results
            results.forEach(item => {
                const li = document.createElement('li');
                li.innerHTML = `<a href="${item.route}">${item.title}</a>`;
                searchResults.appendChild(li);
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
