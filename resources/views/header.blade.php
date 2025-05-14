
<div class="container">
    <div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
        <div class="col-lg-12 d-block">
            <div class="row d-flex">
                <div class="col-md pr-4 d-flex topper align-items-center">
                    <div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>
                    <span class="text">+(84).236.3667117</span>
                </div>
                <div class="col-md pr-4 d-flex topper align-items-center">
                    <div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
                    <span class="text"> info@vku.udn.vn</span>
                </div>
                <div class="col-md-5 pr-4 d-flex topper align-items-center text-lg-right">
                    <span class="text">470 Trần Đại Nghĩa, Hòa Hải, Ngũ hành Sơn, Đà Nẵng</span>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
<div class="container">
  <a class="navbar-brand" href="index.html">D&N</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="oi oi-menu"></span> Menu
  </button>

  <div class="collapse navbar-collapse" id="ftco-nav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active"><a href="{{ route('index') }}" class="nav-link">Trang chủ</a></li>
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sản phẩm</a>
      <div class="dropdown-menu" aria-labelledby="dropdown04">
        @foreach ($category as $key => $item )
          <a class="dropdown-item" href="{{route('sanpham', ['id'=> $item->Category_ID ])}}">{{$item->Name}}</a>
          @endforeach

      </div>
    </li>
      <li class="nav-item"><a href="{{ route('gioithieu') }}" class="nav-link">Giới thiệu</a></li>

      <li class="nav-item"><a href="{{ route('tintuc') }}" class="nav-link">Tin tức</a></li>
      <li class="nav-item"><a href="{{ route('lienhe') }}" class="nav-link">Liên hệ</a></li>
      <li class="nav-item cta cta-colored"><a href="{{ route('giohang') }}" class="nav-link"><span class="icon-shopping_cart"></span></a></li>


      @if (Auth::check())
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-circle-user"></i> {{Auth::user()->Name}} </a>
        <div class="dropdown-menu" aria-labelledby="dropdown04">
            <a class="dropdown-item" href="{{ route('donmua') }}">Đơn mua</a>
            <a class="dropdown-item" href="{{ route('logout') }}">Đăng xuất</a>



        </div>
      </li>


        @else
        <li class="nav-item cta cta-colored"><a href="{{ route('showsignin') }}" class="nav-link"><i class="fa-solid fa-user"></i> Đăng nhập/Đăng kí</a></li>


        @endif
        <li class="nav-item"> <div class="nav-search nav-link">
            <form method="POST" action="{{URL::to('/timkiem')}}">
                @csrf
            <input name="key"  id="search" placeholder="Tìm kiếm" />
            <button type="submit" id="search"><i class="fa fa-search"></i></button>
            </form>
          </div></li>


    </ul>
  </div>
</div>
</nav>
<!-- END nav -->
