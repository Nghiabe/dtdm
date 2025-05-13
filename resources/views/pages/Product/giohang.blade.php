@extends('index')
@section('content')
<div class="hero-wrap hero-bread " style="background-image: url('Asset/images/bg_1.jpg');">
    <div class="container">
      <div class="row no-gutters slider-text align-items-center justify-content-center">
        <div class="col-md-9 ftco-animate text-center">
            <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Trang chủ</a></span> <span>Giỏ hàng</span></p>
          <h1 class="mb-0 bread">Giỏ hàng của tôi</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="ftco-section ftco-cart " >
          <div class="container">
              <div class="row">
              <div class="col-md-12 ftco-animate">
                  <div class="cart-list "  >
                      <table class=" cartdetete table" data-url="{{ route('deletecart')}}">
                          <thead class="thead-primary">
                            <tr class="text-center">

                              <th>&nbsp;</th>
                              <th>Tên sản phẩm</th>
                              <th>Giá</th>
                              <th>Số lượng</th>
                              <th>Tổng tiền</th>
                              <th>&nbsp;</th>
                              <th>&nbsp;</th>
                            </tr>
                          </thead>
                          @php
                              $total =0;
                          @endphp
                          <tbody>
                            @if (Session::has("cart")!=null)
                            @foreach ($carts as $id => $item )
                            @php
                                $total += $item['price']* $item['quantity'];
                            @endphp
                            <tr class="text-center ">


                              <td class="image-prod"><div class="img" style="background-image:url(Asset/images/{{$item['image']}});"></div></td>

                              <td class="product-name">
                                  <h3>{{$item['name']}}</h3>


                              <td class="price">{{number_format($item['price'])}}</td>

                              <td class="quantity">
                                <div class="input-group">
                                    <span class="input-group-text btn btn-danger" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"> -     </span>
                                    <input type="number" value="{{$item['quantity']}}" class="form-control text-center" min="1" max="100">
                                    <span class="input-group-text btn btn-success" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"> +    </span>

                                </div>
                            </td>

                              <td class="total">{{number_format($item['price']*$item['quantity'])}}</td>
                              <td class="product-remove "   ><a href="#" id="cartupdate" data-id="{{$id}}"><i class="fa-solid fa-floppy-disk"></i></a></td>
                              <td class="product-remove "   ><a href="#" id="cartdelete" data-id="{{$id}}"><span class="ion-ios-close"></span></a></td>

                            </tr><!-- END TR-->


                            @endforeach
                            @endif
                            @if (Session::has("cart")==null)
                                <p>Chưa có sản phẩm nào</p>
                            @endif


                          </tbody>
                        </table>
                    </div>
              </div>
          </div>
          <div class="row align-items-end " style="margin-left:450px;">
<form action="{{ route('giohang') }}" method="post" style="width: 700px;">
    @csrf
    <div class="col-md-10">
    <div class="form-group">
        <label for="exampleInputPassword1">Chọn thành phố</label>
          <select name="city" id="city" class="form-control input-sm m-bot15 choose add_delivery city">

                <option name="city"  value="{{ old('city') }}">--Chọn tỉnh thành phố--</option>
            @foreach($city as $key => $ci)
                <option value="{{$ci->matp}}">{{$ci->name_city}}</option>
            @endforeach
        </select>
        @if ($errors->has('city'))
        <span class="text-danger text-left">{{ $errors->first('city') }}</span>
    @endif
    </div>
      </div>
      <div class="col-md-10">
    <div class="form-group">
        <label for="exampleInputPassword1">Chọn quận huyện</label>
          <select name="province" id="province" class="form-control input-sm m-bot15 province choose">
                <option name="province"  value="{{ old('province') }}" >--Chọn quận huyện--</option>
            @foreach($province as $key => $pro)
                <option value="{{$pro->maqh}}">{{$pro->name_quanhuyen}}</option>
            @endforeach
        </select>
        @if ($errors->has('province'))
        <span class="text-danger text-left">{{ $errors->first('province') }}</span>
    @endif
    </div>
      </div>
      <div class="col-md-10"style="border-bottom: 2px solid #e1e1e1">
      <div class="form-group">
        <label for="exampleInputPassword1">Chọn xã phường</label>
          <select class="form-control" name="wards" id="wards" class="form-control input-sm m-bot15 wards ward">
                <option name="ward"  value="{{ old('ward') }}">--Chọn xã phường--</option>
            @foreach($wards as $key => $wards)
                <option  value="{{$wards->xaid}}">{{$wards->name_xaphuong}}</option>
            @endforeach
        </select>
        @if ($errors->has('wards'))
        <span class="text-danger text-left">{{ $errors->first('wards') }}</span>
    @endif
    </div>
      </div>

                  <div class="col-md-10" style="border-bottom: 2px solid #e1e1e1">
                  <div class="form-group">
                      <label for="phone">Nhập mã giảm giá</label>
                    <input name="coupon" type="text" class="form-control coupon" placeholder="Nhập mã giảm giá của bạn" >
                  </div>
                </div>

              <div class="col-lg-10 mt-5 cart-wrap ftco-animate">
                  <div class="cart-total mb-3">

                      <p class="d-flex total-price">
                          <span>Tổng tiền giỏ hàng</span>
                          <span></span>
                          <span>{{number_format($total)}}</span>

                      </p>
                  </div>


              </div>
              <button class="btn btn-primary py-3 px-4 " style="margin-left:240px;" type="submit" name="" >Thanh toán</button>
            </form>

        </div>
          </div>
          </div>
      </section>

      <section class="ftco-section ftco-no-pt ftco-no-pb py-5 bg-light">
    <div class="container py-4">
      <div class="row d-flex justify-content-center py-5">
        <div class="col-md-6">
            <h2 style="font-size: 22px;" class="mb-0">Theo dõi bản tin của chúng tôi</h2>
            <span>Nhận thông tin cập nhật qua email về các cửa hàng mới nhất của chúng tôi và các ưu đãi đặc biệt</span>
        </div>
        <div class="col-md-6 d-flex align-items-center">
          <form action="#" class="subscribe-form">
            <div class="form-group d-flex">
              <input type="text" class="form-control" placeholder="Nhập địa chỉ email">
              <input type="submit" value="Subscribe" class="submit px-3">
            </div>
          </form>

      </div>
    </div>
  </section>
@endsection
