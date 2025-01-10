<div class="sidebar">
    <a target="_blank" href="{{ route('frontend.index') }}" class="sidebar-header">
        <div class="sidebar-header__icon">
            <img src="{{ asset($logo->path ?? 'admin/assets/images/placeholder-logo.png') }}" alt="Logo"
                class="imgFluid">
        </div>
    </a>
    <ul class="sidebar-nav">
        @foreach ($menuItems as $item)
            @php
                $isItemActive = Request::url() === ($item['route'] ?? '');
                $hasActiveSubmenu =
                    isset($item['submenu']) &&
                    array_filter($item['submenu'], function ($submenu) {
                        // Check if the submenu or any subSubMenu matches the current URL
                        return Request::url() === ($submenu['route'] ?? '') ||
                            (isset($submenu['submenu']) &&
                                array_filter($submenu['submenu'], function ($subSubMenu) {
                                    return Request::url() === ($subSubMenu['route'] ?? '');
                                }));
                    });
                $isOpen = $isItemActive || $hasActiveSubmenu;
            @endphp
            <li class="{{ isset($item['submenu']) ? ($isOpen ? 'custom-dropdown open' : 'custom-dropdown') : '' }}">
                <a @if (isset($item['confirm'])) onclick="return confirm('{{ $item['confirm'] }}')" @endif
                    href="{{ $item['route'] ?? 'javascript:void(0)' }}"
                    class="{{ isset($item['submenu']) ? 'custom-dropdown__active' : '' }} {{ $isItemActive ? 'active' : '' }}">
                    <div class="info">
                        <i class="{{ $item['icon'] }}"></i>
                        {{ $item['title'] }}
                    </div>
                    @if (isset($item['submenu']))
                        <div class="icon"><i class='bx bx-chevron-down'></i></div>
                    @endif
                </a>
                @if (isset($item['submenu']))
                    <div class="custom-dropdown__values {{ $isOpen ? 'open' : '' }}">
                        <ul class="values-wrapper">
                            @foreach ($item['submenu'] as $submenu)
                                @php
                                    $isSubmenuActive = Request::url() === ($submenu['route'] ?? '');
                                    $isSubOpen =
                                        $isSubmenuActive ||
                                        (isset($submenu['submenu']) &&
                                            array_filter($submenu['submenu'], function ($subSubMenu) {
                                                return Request::url() === ($subSubMenu['route'] ?? '');
                                            }));
                                @endphp
                                <li class="custom-dropdown custom-dropdown--sub {{ $isSubOpen ? 'open' : '' }}">
                                    <a href="{{ $submenu['route'] ?? 'javascript:void(0)' }}"
                                        class="{{ isset($submenu['submenu']) ? 'custom-dropdown__active' : '' }} {{ $isSubmenuActive ? 'active' : '' }}">
                                        <div class="info">
                                            <i class="{{ $submenu['icon'] }}"></i> {{ $submenu['title'] }}
                                        </div>
                                        @if (isset($submenu['submenu']))
                                            <div class="icon"><i class='bx bx-chevron-down'></i></div>
                                        @endif
                                    </a>
                                    @if (isset($submenu['submenu']))
                                        <div class="custom-dropdown__values {{ $isSubOpen ? 'open' : '' }}">
                                            <ul class="values-wrapper">
                                                @foreach ($submenu['submenu'] as $subSubMenu)
                                                    @php
                                                        $isSubSubmenuActive =
                                                            Request::url() === ($subSubMenu['route'] ?? '');
                                                    @endphp
                                                    <li>
                                                        <a class="{{ $isSubSubmenuActive ? 'active' : '' }}"
                                                            href="{{ $subSubMenu['route'] ?? 'javascript:void(0)' }}">
                                                            <div class="info">
                                                                <i class="{{ $subSubMenu['icon'] }}"></i>
                                                                {{ $subSubMenu['title'] }}
                                                            </div>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </li>
        @endforeach
    </ul>
</div>
