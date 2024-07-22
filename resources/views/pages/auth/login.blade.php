@extends('layout.master2')

@section('content')
    <div class="page-content d-flex align-items-center justify-content-center">

        <div class="row w-100 mx-0 auth-page">
            <div class="col-md-8 col-xl-6 mx-auto">
                <div class="card">
                    <div class="row">
                        <div class="col-md-4 pr-md-0">
                            <div class="auth-left-wrapper"
                                style="background-image: url({{ asset('assets/images/login.svg') }}); 
                                       background-size: 80% auto; 
                                       background-repeat: no-repeat; 
                                       background-position: center;
                                       margin: 20px;">
                            </div>
                        </div>

                        <div class="col-md-8 pl-md-0">
                            <div class="auth-form-wrapper px-4 py-5">
                                <img src="{{ asset('logo.png') }}" alt="Logo" style="max-width: 80px" class="mb-2">
                                <h5 class="text-muted font-weight-normal mb-4">Welcome back! Log in to your account.
                                </h5>
                                <livewire:auth.form-login />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
