@extends('user.layouts.chat-layout')
@section('content')
    @php
        $hideHeaderSearch = true;
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

    <div class="chat chat-bg">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="chat-box">
                        <div class="heading">{{ $case->diagnosis_title }}</div>
                        <div class="chat-box__form">
                            <textarea rows="1" class="chat-input"></textarea>
                            <div class="action-wrapper">
                                <div class="actions-btn">
                                    <button data-tooltip="tooltip" title="Attach Files" type="submit" class="icon-btn">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M9 7C9 4.23858 11.2386 2 14 2C16.7614 2 19 4.23858 19 7V15C19 18.866 15.866 22 12 22C8.13401 22 5 18.866 5 15V9C5 8.44772 5.44772 8 6 8C6.55228 8 7 8.44772 7 9V15C7 17.7614 9.23858 20 12 20C14.7614 20 17 17.7614 17 15V7C17 5.34315 15.6569 4 14 4C12.3431 4 11 5.34315 11 7V15C11 15.5523 11.4477 16 12 16C12.5523 16 13 15.5523 13 15V9C13 8.44772 13.4477 8 14 8C14.5523 8 15 8.44772 15 9V15C15 16.6569 13.6569 18 12 18C10.3431 18 9 16.6569 9 15V7Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </button>
                                    <button class="circle-btn submitButton" disabled>
                                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" class="icon-2xl">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M15.1918 8.90615C15.6381 8.45983 16.3618 8.45983 16.8081 8.90615L21.9509 14.049C22.3972 14.4953 22.3972 15.2189 21.9509 15.6652C21.5046 16.1116 20.781 16.1116 20.3347 15.6652L17.1428 12.4734V22.2857C17.1428 22.9169 16.6311 23.4286 15.9999 23.4286C15.3688 23.4286 14.8571 22.9169 14.8571 22.2857V12.4734L11.6652 15.6652C11.2189 16.1116 10.4953 16.1116 10.049 15.6652C9.60265 15.2189 9.60265 14.4953 10.049 14.049L15.1918 8.90615Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
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
        const chatInput = document.querySelector('.chat-input')
        const submitButton = document.querySelector('.submitButton')
        chatInput.addEventListener('input', function() {
            this.style.height = 'auto';
            if (this.scrollHeight < 140) {
                this.style.height = (this.scrollHeight) + 'px';
            }
            if (this.scrollHeight > 140) {
                this.classList.add('scroll')
            }
        });


        const toggleCommentButton = () => {
            submitButton.disabled = !chatInput.value.trim();
        }
        chatInput.addEventListener('input', toggleCommentButton);
    </script>
@endpush
