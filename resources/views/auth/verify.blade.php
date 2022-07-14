@extends('layouts.app')

@section('content')
<div class="container max-w-xl mx-auto flex justify-center items-center h-screen">
    <div id="alert-additional-content-4" class="p-4 mb-4 bg-red-100 rounded-lg dark:bg-red-100" role="alert">
        <div class="flex items-center">
          <svg class="mr-2 w-5 h-5 text-yellow-700 dark:text-yellow-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
          <h3 class="text-lg font-medium text-yellow-700 dark:text-yellow-800">Verify Your Email Address</h3>
        </div>
        <div class="mt-2 mb-4 text-sm text-yellow-700 dark:text-yellow-800">
            @if (session('resent'))
                A fresh verification link has been sent to your email address.
            @else
                Before proceeding, please check your email for a verification link. If you did not receive the email
            @endif
            
        </div>
        <div class="flex">
            <form class="p-0 shadow-none m-0" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-xs px-3 py-3 mr-2 text-center inline-flex items-center dark:bg-yellow-800 dark:hover:bg-yellow-900">
                    Click here to request another
                </button>
            </form>
        </div>
      </div>
</div>
@endsection
