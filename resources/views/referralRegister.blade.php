@extends('layouts.app')

@section('content')
        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form action="{{ route('registered') }}"method="POST" class="register-form" id="register-form">
                            @csrf

                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Your Name"value="{{ old('name') }}"/>
                                @error('name')
                                <span style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email" value="{{ old('email') }}"/>
                                @error('email')
                                <span style="color:red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="referral_code"><i class="zmdi zmdi-accounts-alt" aria-hidden="true"></i></label>
                                <input type="text" name="referral_code" id="referral_code" placeholder="Enter Referral code (optional)"value="{{ $referral }}" />
                                @error('referral_code')
                                <span style="color:red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" placeholder="Password" />
                                @error('password')
                                <span style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="re_pass" id="re_pass" placeholder="Repeat your password" />
                                @error('re_pass')
                                <span style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term"value="true" {{ !old('agree-term') ?: 'checked' }}/>
                                <label for="agree-term" class="label-agree-term" ><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                                @error('agree-term')
                                <span style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>

                        @if (Session::has('success'))
                        <p style="color: green">{{ Session::get('success') }}<a href="{{ route('login')}}" class="signup-image-link" style="color: blue">login here</a></p>
                        @endif

                        @if (Session::has('error'))
                        <p style="color: red">{{ Session::get('error') }}</p>
                        @endif

                    </div>
                    <div class="signup-image">
                        <figure><img src="{{asset('asset')}}/images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="{{ route('login')}}" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
        </section>

@endsection
