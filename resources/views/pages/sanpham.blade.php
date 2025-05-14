@extends('index')
@section('content')
<div class="hero-wrap hero-bread" style="background-image: url('Asset/images/bg_1.jpg');">
    <div class="container">
      <div class="row no-gutters slider-text align-items-center justify-content-center">
        <div class="col-md-9 ftco-animate text-center">
            <p class="breadcrumbs"><span class="mr-2"><a href="">Trang chủ</a></span> <span>Sản phẩm</span></p>
          <h1 class="mb-0 bread">{{$namecategory->Name}}</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
            <div class="col-md-7 heading-section ftco-animate text-center">
                <span class="subheading" style="text-transform: uppercase;">SẢN PHẨM CỦA DANH MỤC {{$namecategory->Name}}</span>
            </div>
          </div>

          <div class="row" style="margin-left:900px">
            <div class="col-md-12">
              <label for="amount">Sắp xếp theo</label>
              <form action="{{ route('loc') }}" method="POST" >
                @csrf
                <select name="sort" id="sort" class="form-control">
                  <option value="none">--Lọc--</option>
                  <option value="tang_dan">--Giá tăng dần--</option>
                  <option value="giam_dan">--Giá giảm dần--</option>
                  <option value="kytu_az">--A đến Z--</option>
                  <option value="kytu_za">--Z đến A--</option>

                </select>
                <button class="btnRegister" type="submit" style="background: #82ae46; margin-top:15px; margin-bottom:15px">Lọc</button>


                     </form>
            </div>
          </div>
          <div class="row">
            @foreach ($sanpham as $key => $item )
              <div class="col-md-6 col-lg-3 ftco-animate">
                  <div class="product">
                      <a href="{{route('chitietsanpham', ['id'=> $item->product_id])}}" class="img-prod"><img class="img-fluid" src="Asset/images/{{$item->Thumbnail}}" alt="Colorlib Template">
                          <div class="overlay"></div>
                      </a>
                      <div class="text py-3 pb-4 px-3 text-center">
                          <h3><a href="{{route('chitietsanpham', ['id'=> $item->product_id])}}">{{$item->Title}}</a></h3>
                          <div class="d-flex">
                              <div class="pricing">
                                  <p class="price"><span>{{number_format($item->Discount,0,',','.')}}đ</span></p>
                              </div>
                          </div>
                          <div class="bottom-area d-flex px-3">
                              <div class="m-auto d-flex">
                                  <a href="{{route('chitietsanpham', ['id'=> $item->product_id])}}" class="add-to-cart d-flex justify-content-center align-items-center text-center">
                                      <span><i class="ion-ios-menu"></i></span>
                                  </a>
                                  <form method="POST" action="{{ route('addtocart', ['id' => $item->product_id]) }}">
    @csrf
    <input type="hidden" name="quantity" value="1">
    <button type="submit" class="d-flex justify-content-center align-items-center mx-1" style="border:none; background:none;">
        <span><i class="ion-ios-cart"></i></span>
    </button>
</form>


</a>

                                  <a class="heart d-flex justify-content-center align-items-center " id="{{$item->product_id}}" onclick="add_wistlist(this.id);">
                                      <span><i class="ion-ios-heart"></i></span>
                                  </a>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              @endforeach
          </div>
          {{-- <div class="col-sm-7 text-right text-center-xs" >
            <ul class="pagination pagination-sm m-t-none m-b-none">
               {!!$sanpham->links()!!}
            </ul>
          </div> --}}
      </div>
  </section>

      <section class="ftco-section ftco-no-pt ftco-no-pb py-5 bg-light">
    <div class="container py-4">
      <div class="row d-flex justify-content-center py-5">
        <div class="col-md-6">
            <h2 style="font-size: 22px;" class="mb-0">Đăng kí nhận tin khuyến mãi</h2>
            <span>Nhận thông tin cập nhật qua email về cửa hàng mới nhất của chúng tôi và các ưu đãi đặc biệt</span>
        </div>
        <div class="col-md-6 d-flex align-items-center">
          <form action="#" class="subscribe-form">
            <div class="form-group d-flex">
              <input type="text" class="form-control" placeholder="Email của bạn..">
              <input type="submit" value="Subscribe" class="submit px-3">
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
@endsection
