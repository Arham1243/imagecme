@extends('user.layouts.chat-layout')
@section('content')
    @php
        $hideHeaderSearch = true;
        $hideAlpine = true;
    @endphp
    <div class="dashboard-header-wrapper">
        <div class="row g-0">
            <div class="col-md-9">
                <div class="dashboard-header">
                    <div class="row justify-content-between">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="header-icon">
                                    <img src="{{ asset($logo->path ?? 'admin/assets/images/placeholder-logo.png') }}"
                                        alt="Logo" class="imgFluid">
                                </div>
                                <h2 class="mb-0">Ask AI</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-header  d-flex justify-content-end pe-2"
                    style=" padding-left: 0 !important;  padding-right: 0.5rem !important; padding-bottom: 0 !important;">
                    <div class="user-profile">
                        <div class="name">
                            <div class="name1">{{ Auth::user()->email }}</div>
                            <div class="role">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</div>
                        </div>
                        <div class="user-image-icon">
                            <i class='bx bxs-user-circle'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="app">
        @include('user.cases-management.component.chatBox')
    </div>
@endsection
@push('css')
    <script src="https://cdn.jsdelivr.net/npm/vue@3"></script>
    <style>
        body {
            color: #ECECEC;
            background: #212121;
        }

        body::-webkit-scrollbar {
            width: 14px;
        }

        body::-webkit-scrollbar-track {
            background: transparent;
        }

        body::-webkit-scrollbar-thumb {
            background: #424242;
        }


        .loader-mask {
            background: #212121
        }

        .loader {
            border: 4px solid #ECECEC;
            border-bottom-color: transparent;
        }

        .dashboard-header h2,
        .user-image-icon i,
        .user-profile .name1,
        .user-profile .role {
            color: #ECECEC;
            opacity: 1;
        }
    </style>
@endpush
@push('js')
    <script>
        const app = createApp(ChatComponent);
        app.mount('#app');
    </script>
@endpush
