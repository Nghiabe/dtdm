<style>
    .register{
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
    margin-top: 3%;
    padding: 3%;
}
.register-left{
    text-align: center;
    color: #fff;
    margin-top: 4%;
}
.register-left input{
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    width: 60%;
    background: #f8f9fa;
    font-weight: bold;
    color: #383d41;
    margin-top: 30%;
    margin-bottom: 3%;
    cursor: pointer;
}
.register-right{
    background: #f8f9fa;
    border-top-left-radius: 10% 50%;
    border-bottom-left-radius: 10% 50%;
}
.register-left img{
    margin-top: 15%;
    margin-bottom: 5%;
    width: 25%;
    -webkit-animation: mover 2s infinite  alternate;
    animation: mover 1s infinite  alternate;
}
@-webkit-keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}
@keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}
.register-left p{
    font-weight: lighter;
    padding: 12%;
    margin-top: -9%;
}
.register .register-form{
    padding: 10%;
    margin-top: 10%;
}
.btnRegister{

    margin-top: 10%;
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    background: #0062cc;
    color: #fff;
    font-weight: 600;
    width: 50%;
    cursor: pointer;
    margin-left: 30%;
}
.register .nav-tabs{
    margin-top: 3%;
    border: none;
    background: #0062cc;
    border-radius: 1.5rem;
    width: 28%;
    float: right;
}
.register .nav-tabs .nav-link{
    padding: 2%;
    height: 34px;
    font-weight: 600;
    color: #fff;
    border-top-right-radius: 1.5rem;
    border-bottom-right-radius: 1.5rem;
}
.register .nav-tabs .nav-link:hover{
    border: none;
}
.register .nav-tabs .nav-link.active{
    width: 100px;
    color: #0062cc;
    border: 2px solid #0062cc;
    border-top-left-radius: 1.5rem;
    border-bottom-left-radius: 1.5rem;
}
.register-heading{
    text-align: center;
    margin-top: 8%;
    margin-bottom: -15%;
    color: #495057;
}
.btnbtn{
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    width: 60%;
    background: #f8f9fa;
    font-weight: bold;
    color: #383d41;
    margin-top: 30%;
    margin-bottom: 3%;
    cursor: pointer;
}
#a{
    color: #383d41;
}
.social{
  margin-top: 30px;
  display: flex;
  margin-left: 270px;
}
.social div{
  background: red;
  width: 150px;
  border-radius: 3px;
  padding: 5px 10px 10px 5px;
  background-color: rgba(177, 171, 171, 0.27);
  color: #075af4;
  text-align: center;
}
.social div:hover{
  background-color:#0062cc;
  color: white;
}
.social .fb{
  margin-left: 25px;
}
.social i{
  margin-right: 4px;
}


</style>
@extends('index')

@section('content')

@if ( Session::has('error') )
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
            <button class="btnbtn" type="submit" ><a href='dangki' id="a" >ĐĂNG KÍ</a></button>
        </div>
        <div class="col-md-9 register-right">

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <h3 class="register-heading">ĐĂNG NHẬP</h3>
                    <form action="{{ route('signin') }}" method="post">
                        @csrf
                    <div class="row register-form">
                        <div class="col-md-12">

                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Email *" value="" name="email" />
                                @if ($errors->has('email'))
                                <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                            @endif

                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Mật khẩu *" value=""  name="password"/>
                                @if ($errors->has('password'))
                                <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                            @endif
                            </div>
                            <div class="row align-items-center remember">
                                <input type="checkbox" name="remember">Remember Me
                            </div>
                            <div class="d-flex justify-content-center">
                                <a href="{{url('/login_facebook/facebook')}}">Forgot your password?</a>
                            </div>
                             <button class="btnRegister" type="submit">ĐĂNG NHẬP</button>
                             <br><br> <br>
                             <b style="margin-left:400px">Hoặc:</b>
                             <br><br>

                             <div class="social">
                               <a href="{{url('/login_google/google')}}"  class="go"> <div class="go"><i class="fab fa-google" ></i>  Google</div></a>
                               <a href="{{url('/login_facebook/facebook')}}"  class="go"><div class="fb"><i class="fab fa-facebook"></i>  Facebook</div></a>

                              </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
    @endsection


