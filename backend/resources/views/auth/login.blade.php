@extends('layouts.app')

@section('content')

<div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
    <div class="card card0 border-0">
        <div class="row d-flex">
            <div class="col-lg-12">
                <div class="card1 pb-5">
                    <div class="row px-4 py-4 ml-4"> Your Logo </div>
                    <div class="row px-3 justify-content-center mb-5 border-line"> 
                        <form class="form-login" method="POST" action="{{ route('admin.login') }}">
                            @csrf
                            <div class="card2 card border-0 px-4 py-5">
                                <div class="row mb-4 px-3">
                                    <h6 style="text-decoration: underline;" class="mb-0 mr-4 mt-2">Admin Sign In</h6>
                                </div>
                                <div class="row px-3"> 
                                    <label class="mb-1">
                                     <h6 class="mb-0 text-sm">Email Address</h6>
                                    </label> 
                                    <input class="mb-4 @error('email') is-invalid @enderror" type="text" name="email" value="{{ old('email') }}" placeholder="Enter a valid email address" required autocomplete="email" autofocus> 
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row px-3"> 
                                    <label class="mb-1">
                                        <h6 class="mb-0 text-sm">Password</h6>
                                    </label> 
                                    <input class="@error('password') is-invalid @enderror" type="password" name="password" placeholder="Enter password" required autocomplete="current-password"> 
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row px-3 mb-4">
                                    <div class="custom-control custom-checkbox custom-control-inline"> 
                                        <input id="chk1" type="checkbox" name="remember" class="custom-control-input" {{ old('remember') ? 'checked' : '' }}> 
                                        <label for="chk1" class="custom-control-label text-sm">Remember me</label> 
                                    </div> 
                                    <!--<a href="#" class="ml-auto mb-0 text-sm">Forgot Password?</a>-->
                                </div>
                                <div class="row mb-3 px-3"> 
                                    <button type="submit" class="btn btn-blue text-center">Login</button> 
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-blue py-4">
            <div class="row px-3"> 
                <small class="ml-4 ml-sm-5 mb-2">Copyright &copy; {{ date('Y') }}. Sunglobal All rights reserved.</small>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
    @parent
    <style>
        .invalid-feedback{
            display: inline-block !important;
            margin-top: 0px !important;
        }
    </style>
@stop

@section('scripts')
    @parent
@stop
