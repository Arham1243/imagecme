<div class="form-box">
    <div class="form-box__header">
        <div class="title">Chart Types
        </div>
    </div>
    <div class="form-box__body p-0">
        <ul class="settings">
            <li class="settings-item">
                <a href="{{ route('user.analytics.cases') }}"
                    class="settings-item__link {{ Request::routeIs('user.analytics.cases') ? 'active' : '' }}">
                    <i class="bx bx-search-alt"></i> Cases
                </a>
            </li>
            <li class="settings-item">
                <a href="{{ route('user.analytics.cases-insights') }}"
                    class="settings-item__link {{ Request::routeIs('user.analytics.cases-insights') ? 'active' : '' }}">
                    <i class="bx bx-bar-chart-alt"></i> Cases Insights
                </a>
            </li>
        </ul>
    </div>
</div>
