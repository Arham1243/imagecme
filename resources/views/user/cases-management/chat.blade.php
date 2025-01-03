@extends('user.layouts.chat-layout')
@section('content')
    @php
        $hideHeaderSearch = true;
        $hideAlpine = true;
    @endphp
    <div class="dashboard-header-wrapper">
        <div class="dashboard-header">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('user.cases.edit', $case->id) }}" class="back-btn"><i class="bx bx-chevron-left"></i></a>
                <a href="{{ route('admin.dashboard') }}" class="header-icon">
                    <img src="{{ asset($logo->path ?? 'admin/assets/images/placeholder-logo.png') }}" alt="Logo"
                        class="imgFluid">
                </a>
                <h2 class="mb-0">Ask AI</h2>

            </div>
            <div class="d-flex gap-3">
                <input class="heading" id="title-input" value="{{ $case->diagnosis_title }}">
                <form id="publishForm" action="{{ route('user.cases.chat.publish', $case->id) }}" method="POST">
                    <div class="form-check form-switch" data-enabled-text="Publish Conversation"
                        data-disabled-text="Publish Conversation">
                        @csrf
                        <input id="publishSwitch" class="form-check-input" data-toggle-switch=""
                            {{ $case->publish_ai_conversation === 1 ? 'checked' : '' }} type="checkbox" value="1"
                            name="publish_conversation">
                        <label class="form-check-label" for="publishSwitch"></label>
                    </div>
                </form>
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

        .dashboard-header h2,
        .dashboard-header .heading {
            color: #b4b4b4;
            font-size: 1.35rem;
            width: fit-content;
            border: none;
            background: none;
            text-align: center;
            border-radius: 0.35rem;
            text-transform: inherit
        }

        .dashboard-header input.heading:focus {
            outline: 1px solid #b4b4b4;
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

        .form-switch .form-check-input:checked {
            filter: invert(1);
        }
    </style>
@endpush
@push('js')
    @include('user.cases-management.component.chatBoxJs')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const publishSwitch = document.getElementById('publishSwitch');
            const publishForm = document.getElementById('publishForm');

            if (publishSwitch && publishForm) {
                publishSwitch.addEventListener('change', function() {
                    publishForm.submit();
                });
            }
        });

        document.getElementById('title-input').addEventListener('blur', function() {
            const case_type = 'ask_ai_image_diagnosis';
            const title = this.value;
            const case_save_route = '{{ route('user.api.cases.update', $case->id) }}';

            axios.post(case_save_route, {
                    diagnosis_title: title,
                    case_type: case_type
                }, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => {
                    showMessage('Title saved successfully.', 'success');
                })
                .catch(error => {
                    showMessage(error.response?.data?.message || 'An error occurred while saving the title.',
                        'error');
                });
        });
    </script>
@endpush
