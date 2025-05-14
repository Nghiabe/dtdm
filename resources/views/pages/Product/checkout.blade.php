@extends('index')

@section('content')

<div class="hero-wrap hero-bread" style="background-image: url('Asset/images/bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Trang chủ</a></span> <span>Thanh toán</span></p>
                <h1 class="mb-0 bread">Thanh toán</h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 ftco-animate">
                @if (Session::has('soluong'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <strong>{{ Session::get('soluong') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                    </div>
                @endif
                <form action="{{ route('checkout') }}" class="billing-form" method="POST">
                    @csrf
                    <h3 class="mb-4 billing-heading">Thông tin khách hàng</h3>
                    <div class="row align-items-end">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Họ và tên</label>
                                <input name="FullName" type="text" class="form-control" value="{{ old('FullName') }}" placeholder="Họ và tên người nhận">
                                @if ($errors->has('FullName'))
                                    <span class="text-danger text-left">{{ $errors->first('FullName') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Số điện thoại</label>
                                <input value="{{ old('phone') }}" name="phone" type="text" class="form-control" placeholder="Số điện thoại người nhận">
                                @if ($errors->has('phone'))
                                    <span class="text-danger text-left">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12" style="border-bottom: 1px solid #e1e1e1">
                            <div class="form-group">
                                <label for="phone">Địa chỉ</label>
                                @if (Session::get('add'))
                                    <input name="adr" type="text" class="form-control" value="{{Session::get('add')}}" disabled>
                                    @if ($errors->has('Address'))
                                        <span class="text-danger text-left">{{ $errors->first('Address') }}</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12" style="border-bottom: 1px solid #e1e1e1">
                            <div class="form-group">
                                <label for="phone">Thôn, số nhà, tòa nhà,...</label>
                                <input name="Address" type="text" class="form-control" placeholder="Thôn, số nhà,.." value="{{ old('Address') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <h3 class="mb-4 billing-heading col-md-12">Đơn hàng của bạn</h3>
                        <div class="row mt-5 pt-3 check">
                            <div class="col-md-12 d-flex mb-5">
                                <div class="cart-detail cart-total p-3 p-md-4">
                                    <p class="d-flex">
                                        <span>Sản phẩm</span>
                                        <span>Sl</span>
                                        <span>Giá tiền</span>
                                    </p>
                                    @php
                                    $total = 0;
                                    @endphp
                                    @foreach ($carts as $id => $item)
                                    @php
                                    $total += $item['price'] * $item['quantity'];
                                    @endphp
                                    <p class="d-flex">
                                        <span>{{$item['name']}}</span>
                                        <span>{{$item['quantity']}}</span>
                                        <span>{{number_format($item['price'])}}</span>
                                    </p>
                                    @endforeach
                                    <p style="border-bottom: 1px solid #e1e1e1;"></p>
                                    <p class="d-flex" id="totol">
                                        <span style="">Tổng tiền hàng</span>
                                        <span></span>
                                        <span> {{number_format($total)}}</span>
                                    </p>
                                    @if (Session::get('fee'))
                                    <p class="d-flex" id="totol">
                                        <span>Phí vận chuyển</span>
                                        <span></span>
                                        <span>{{number_format(Session::get('fee'))}}</span>
                                    </p>
                                    @endif
                                    <p class="them"></p>
                                    @if (Session::get('cou'))
                                    <p class="d-flex" id="totol">
                                        <span>Giảm giá</span>
                                        <span></span>
                                        <span>{{Session::get('cou')}}</span>
                                    </p>
                                    @endif
                                    @php
                                    $total1 = $total + Session::get('fee') - Session::get('cou');
                                    @endphp
                                    <hr>
                                    <p class="d-flex total-price" style="font-size: 18px;color: #1c1c1c;font-weight: 700;border-bottom: 1px solid #e1e1e1;border-top: 1px solid #e1e1e1;padding-bottom: 15px;margin-bottom: 15px;padding-top: 15px;">
                                        <span>Tổng thanh toán</span>
                                        <span></span>
                                        <span>{{number_format($total1)}}</span>
                                    </p>
                                    <h3 class="billing-heading mb-4" id="totol">Hình thức thanh toán</h3>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <div class="radio">
                                                <label><input type="radio" name="Payments" value="Direct" class="mr-2" checked>Thanh toán trực tiếp</label>
                                                <label><input type="radio" name="Payments" value="ATM" class="mr-2"> Qua thẻ ngân hàng</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="emailaddress">Ghi chú đơn hàng</label>
                                        <input name="note" type="text" class="form-control" placeholder="Ghi chú">
                                    </div>
                                    <button class="btnRegister btn btn-primary py-3 px-4" type="submit">Đặt hàng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div> <!-- .col-md-8 -->
        </div>
    </div>
</section> <!-- .section -->

<section class="ftco-section ftco-no-pt ftco-no-pb py-5 bg-light">
    <div class="container py-4">
        <div class="row d-flex justify-content-center py-5">
            <div class="col-md-6">
                <h2 style="font-size: 22px;" class="mb-0">Subcribe to our Newsletter</h2>
                <span>Get e-mail updates about our latest shops and special offers</span>
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <form action="#" class="subscribe-form">
                    <div class="form-group d-flex">
                        <input type="text" class="form-control" placeholder="Enter email address">
                        <input type="submit" value="Subscribe" class="submit px-3">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
