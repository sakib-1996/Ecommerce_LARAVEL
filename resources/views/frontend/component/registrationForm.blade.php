<div class="main_content">
    <!-- START LOGIN SECTION -->
    <div class="login_register_wrap section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-md-10">
                    <div class="login_wrap">
                        <div class="padding_eight_all bg-white">
                            <div class="heading_s1">
                                <h3>Create an Account</h3>
                            </div>
                            <form method="post" action="{{ route('registration') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder="Enter Your Name" value="{{ old('name') }}">

                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        name="email" placeholder="Enter Your Email" value="{{ old('email') }}">

                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" placeholder="Enter Your Phone" value="{{ old('phone') }}">

                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input class="form-control @error('password') is-invalid @enderror" type="password"
                                        name="password" placeholder="Password" value="{{ old('password') }}">
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                        type="password" name="password_confirmation" placeholder="Confirm Password"
                                        value="{{ old('password_confirmation') }}">
                                    @error('password_confirmation')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>



                                <div class="form-group mb-3">
                                    <button type="submit" class="btn btn-fill-out btn-block"
                                        name="register">Register</button>
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
                            <div class="form-note text-center">Already have an account? <a href="login.html">Log in</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END LOGIN SECTION -->

    <!-- START SECTION SUBSCRIBE NEWSLETTER -->
    <div class="section bg_default small_pt small_pb">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="heading_s1 mb-md-0 heading_light">
                        <h3>Subscribe Our Newsletter</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="newsletter_form">
                        <form>
                            <input type="text" required="" class="form-control rounded-0"
                                placeholder="Enter Email Address">
                            <button type="submit" class="btn btn-dark rounded-0" name="submit"
                                value="Submit">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- START SECTION SUBSCRIBE NEWSLETTER -->
</div>
