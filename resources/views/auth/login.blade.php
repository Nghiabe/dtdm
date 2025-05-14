@extends('index')

@section('content')

@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <strong>{{ Session::get('error') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
    </div>
@endif

<div class="container register">
    <div class="row">
        <div class="col-md-3 register-left">
            <h3>Chào mừng bạn đến với D&N!</h3>
            <p>Để giữ kết nối với chúng tôi, vui lòng đăng nhập bằng thông tin cá nhân của bạn.</p>
            <!-- Chuyển href sang đăng ký đúng -->
            <a href="{{ route('showsignup') }}" class="btnbtn">ĐĂNG KÍ</a>
        </div>
        <div class="col-md-9 register-right">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <h3 class="register-heading">ĐĂNG NHẬP</h3>
                    <form action="{{ route('signin') }}" method="POST">
                        @csrf
                        <div class="row register-form">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Email *" value="" name="email" required/>
                                    @if ($errors->has('email'))
                                    <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Mật khẩu *" value="" name="password" required/>
                                    @if ($errors->has('password'))
                                    <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>

                                <div class="row align-items-center remember">
                                    <input type="checkbox" name="remember"> Remember Me
                                </div>

                                <div class="d-flex justify-content-center">
                                    <a href="{{url('/login_facebook/facebook')}}">Quên mật khẩu?</a>
                                </div>

                                <button class="btnRegister" type="submit">ĐĂNG NHẬP</button>
                            </div>
                        </div>

                        <br><br> <br>
                        <b style="margin-left:400px">Hoặc:</b>
                        <br><br>

                        <!-- Social login buttons -->
                        <div class="social">
                            <a href="{{ url('/login_google/google') }}" class="go">
                                <div class="go">
                                    <i class="fab fa-google"></i> Google
                                </div>
                            </a>
                            <a href="{{ url('/login_facebook/facebook') }}" class="go">
                                <div class="fb">
                                    <i class="fab fa-facebook"></i> Facebook
                                </div>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
