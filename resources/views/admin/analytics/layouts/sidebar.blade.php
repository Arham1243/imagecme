<div class="form-box">
    <div class="form-box__header">
        <div class="title">Chart Types
        </div>
    </div>
    <div class="form-box__body p-0">
        <ul class="settings">
            <li class="settings-item">
                <a href="{{ route('admin.analytics.cases') }}"
                    class="settings-item__link {{ Request::routeIs('admin.analytics.cases') ? 'active' : '' }}">
                    <i class="bx bxs-group"></i> Cases
                </a>
            </li>
            <li class="settings-item">
                <a href="{{ route('admin.analytics.users') }}"
                    class="settings-item__link {{ Request::routeIs('admin.analytics.users') ? 'active' : '' }}">
                    <i class="bx bx-search-alt"></i> Users
                </a>
            </li>
            <li class="settings-item">
                <a href="{{ route('admin.analytics.users-specific') }}"
                    class="settings-item__link  {{ Request::routeIs('admin.analytics.users-specific') ? 'active' : '' }}">
                    <i class="bx bx-search-alt"></i> Users Specific
                </a>
            </li>
        </ul>
    </div>
</div>
