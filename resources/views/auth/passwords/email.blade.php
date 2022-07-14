@extends('layouts.app')

@section('content')
<div class="w-full h-screen md:max-w-[560px] mx-auto flex flex-col items-center px-4 mt-[100px]">
    <h3 class="text-2xl font-medium text-gray-900 dark:text-white mb-8">Reset Password</h3>
    @if (session('status'))
        <div class="alert alert-success text-center mb-8" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <form method="POST" action="{{ route('password.email') }}" class="min-w-[450px]">
            @csrf

            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Your email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="text-sm font-light text-red-500" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
