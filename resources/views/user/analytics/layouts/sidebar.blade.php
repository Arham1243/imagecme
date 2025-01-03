<div class="form-box">
    <div class="form-box__header">
        <div class="title">Chart Types
        </div>
    </div>
    <div class="form-box__body p-0">
        <ul class="settings">
            <li class="settings-item">
                <a href="{{ route('admin.analytics.cases') }}"
                    class="settings-item__link {{ Request::routeIs('user.analytics.cases') ? 'active' : '' }}">
                    <i class="bx bxs-group"></i> Cases
                </a>
            </li>
        </ul>
    </div>
</div>
