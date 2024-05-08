    <!-- START MAIN CONTENT -->
    <div class="main_content">

        <!-- START LOGIN SECTION -->
        <div class="login_register_wrap">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-md-10">
                        <div class="login_wrap">
                            <div class="padding_eight_all bg-white">
                                <div class="heading_s1">
                                    <h3>Login Your Account</h3>
                                </div>
                                <form action="{{ route('login') }}" method="post" enctype="multipart/form-data">
                                    @csrf <!-- CSRF protection token -->

                                    @if (session('error'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>{{ session('error') }}</strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                            </button>
                                        </div>
                                    @endif

                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control @error('login') is-invalid @enderror"
                                            name="login" placeholder="Enter Your Email or Phone Number"
                                            value="{{ old('login') }}">
                                        @error('login')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>


                                    <div class="form-group mb-3">
                                        <input class="form-control @error('password') is-invalid @enderror"
                                            type="password" name="password" placeholder="Password">
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('registration') }}">Registration</a>
                                        <!-- Link to registration page -->
                                        <button type="submit" class="btn btn-fill-out">Login</button>
                                        <!-- Submit button for login -->
                                    </div>
                                </form>


                                <div class="different_login">
                                    <span> or</span>
                                </div>
                                <ul class="btn-login list_none text-center">
                                    <li><a href="#" class="btn btn-facebook"><i
                                                class="ion-social-facebook"></i>Facebook</a></li>
                                    <li><a href="#" class="btn btn-google"><i
                                                class="ion-social-googleplus"></i>Google</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END LOGIN SECTION -->
    </div>
    <!-- END MAIN CONTENT -->
