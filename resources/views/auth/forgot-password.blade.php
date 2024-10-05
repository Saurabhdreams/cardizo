@extends('layouts.auth')
@section('title')
    {{ __('messages.common.forgot_password') }}
@endsection
@section('content')
    <div class="forget-password-section bg-white overflow-hidden position-relative">
        <div class="top-vector">
            <img src="{{ asset('assets/images/top-vector.png') }}">
        </div>
        <div class="bottom-vector">
            <img src="{{ asset('assets/images/bottom-vector.png') }}">
        </div>
        <div class="row">
            <div class="col-md-6 col-12 p-0">
                <div class="forget-password-img">
                    <img src="{{ asset($registerImage) }}" alt="Register Image" class="w-100 h-100">
                </div>
            </div>
            <div class="col-md-6 col-12 p-0 d-flex flex-column justify-content-center">
                <div class="forget-password-form ">
                    <div class="col-12 text-center mt-0 mb-5">
                        <a href="{{ route('home') }}" class="image">
                            <img alt="Logo" src="{{ getLogoUrl() }}" class="img-fluid logo-fix-size">
                        </a>
                       
                    </div>
                 
                    <div class="bg-white width-540 px-5 py-10 mx-auto">
						   <div class="width-540">
                        @include('layouts.errors')
                        @include('flash::message')
                        @if (Session::has('status'))
                            <div class="alert alert-success fs-4 text-white align-items-center" role="alert">
                                <i class="fa-solid fa-face-smile me-4"></i>
                                {{ Session::get('status') }}
                            </div>
                        @endif
                    </div>
                        <h1 class="text-center mb-7">{{ __('messages.common.forgot_password') . ' ?' }}</h1>
                        <div class="fw-bold fs-4 mb-5 text-center">
                            {{ __('messages.placeholder.enter_your_email_to_reset') }}</div>
                        <div class="fs-4 text-center mb-5">{{ __('messages.placeholder.forgot_your_password_no_problem') }}
                        </div>
                        <form class="form w-100" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="row">
                                <div class="mb-4 z-index-9">
                                    <label for="email" class="form-label">
                                        {{ __('messages.user.email') . ':' }}<span class="required"></span>
                                    </label>
                                    <input id="email" class="form-control" type="email" value="{{ old('email') }}"
                                        required autofocus name="email" autocomplete="off"
                                        placeholder="{{ __('messages.user.email') }}" />
                                </div>
                            </div>
                            <div class="row ">
                                <!-- Submit Field -->
                                <div class="form-group col-sm-12 d-flex text-start align-items-center z-index-9">
                                    <button type="submit" class="btn reset-link">
                                        <span class="indicator-label text-light">
                                            {{ __('messages.email_password_reset_link') }}</span>
                                    </button>
                                    <a href="{{ route('login') }}"
                                        class="btn btn-secondary my-0 ms-5 me-0">{{ __('messages.common.cancel') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <footer>
                    <div class="container-fluid padding-0 mb-5 copy-right">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-xl-6 w-100">
                               <div class="copyright text-center text-muted">
                                    &copy; {{ date('Y') }} <span class="font-weight-bold ml-1">{{ getAppName() }}.</span>
                                       {{ __('messages.placeholder.all_rights_reserve'). '. ' }}  1XL Info LLP
                <p class="text-gray-600">A product by <a href="https://1xl.com/" target="blank">1XL.com</a></p>
                               </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
@endsection
