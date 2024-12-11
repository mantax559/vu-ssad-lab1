@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end" for="name">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" class="form-control @error('name') is-invalid @enderror" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end" for="email">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" class="form-control @error('email') is-invalid @enderror" name="email" type="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end" for="password">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" class="form-control @error('password') is-invalid @enderror" name="password" type="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end" for="password-confirm">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" class="form-control" name="password_confirmation" type="password" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
