@extends('user.layouts.chat-layout')
@section('content')
    @php
        $hideHeaderSearch = true;
        $hideAlpine = true;
    @endphp
    <div class="dashboard-header-wrapper">
        <div class="dashboard-header">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="header-icon">
                    <img src="{{ asset($logo->path ?? 'admin/assets/images/placeholder-logo.png') }}" alt="Logo"
                        class="imgFluid">
                </a>
                <h2 class="mb-0">Ask AI</h2>

            </div>
            <div class="d-flex gap-3">
                <h2 class="mb-0">{{ $case->diagnosis_title }}</h2>

                <div class="form-check form-switch" data-enabled-text="Publish Conversation"
                    data-disabled-text="Publish Conversation">
                    <input class="form-check-input" data-toggle-switch=""
                        {{ isset($sectionContent->publish_conversation) ? 'checked' : '' }} type="checkbox"
                        id="publish_conversation" value="1" name="content[publish_conversation]">
                    <label class="form-check-label" for="publish_conversation"></label>
                </div>
            </div>
            <div class="d-flex justify-content-end pe-2"
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
    <div id="app">
        @include('user.cases-management.component.chatBox')
    </div>
@endsection
@push('css')
    <script src="https://cdn.jsdelivr.net/npm/vue@3"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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

        .user-image-icon i,
        .user-profile .name1,
        .user-profile .role {
            color: #ECECEC;
            opacity: 1;
        }

        .dashboard-header h2 {
            color: #b4b4b4;
            font-size: 1.35rem;
        }

        .dashboard-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.25rem 1rem;
            background: #212121;
            margin-bottom: 1.5rem;
            position: fixed;
            width: 100%;
            left: 0;
            top: 0;
            z-index: 100000;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .form-check-input:checked {
            background-color: #000000;
        }
    </style>
@endpush
@push('js')
    @include('user.cases-management.component.chatBoxJs')
@endpush
