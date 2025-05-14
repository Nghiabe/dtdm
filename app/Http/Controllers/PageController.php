<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\Address; 
use App\Models\Product as ModelsProduct;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model\Product;
use DB;
use App\Models\Cart;
use Illuminate\Support\Facades\Mail;
use App\Models\City;
use Illuminate\Support\Facades\Cookie;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Freeship;
use Illuminate\Contracts\Session\Session as SessionSession;
use Session;
use App\Models\Coupon;

use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
class PageController extends Controller
{
    public function getdupdatecart(Request $request)
{
    $id = $request->input('id');
    $quantity = $request->input('quantity'); // Số lượng mới

    // Lấy giỏ hàng từ cookie
    $cart = Cookie::get('cart') ? json_decode(Cookie::get('cart'), true) : [];

    // Kiểm tra nếu sản phẩm có trong giỏ hàng
    if (isset($cart[$id])) {
        // Cập nhật số lượng sản phẩm
        $cart[$id]['quantity'] = $quantity;
        // Cập nhật lại giỏ hàng trong cookie
        Cookie::queue('cart', json_encode($cart), 60 * 24 * 30);
    }

    return response()->json([
        'code' => 200,
        'message' => 'Cart updated successfully',
        'cart_component' => view('pages.Product.giohang', compact('cart'))->render()  // Render lại giỏ hàng
    ], 200);
}

	 public function getindex()
    {
        $blog = DB::table('blog')->orderby('id','desc')->get();
        $hot = DB::table('products') -> where('hot','1')->orderby('id','desc')->paginate(12);
        $category = DB::table('category') ->get();
        return view('pages.trangchu', compact('hot', 'blog', 'category' )) ;



    }
    public function gettimkiem(Request $request)

    {
        $key= $request->key;

        $search = DB::table('products') -> where('Title','like', '%'.$key.'%')->paginate(16);
        $category = DB::table('category') ->get();
        return view('pages.Product.search', compact('search', 'category', 'key' ));
    }

    public function getloc(Request $request)

    {
        $sort= $request->sort;
        if ($sort=='tang_dan') {
            $loc = DB::table('products')->orderby('Price','ASC') ->paginate(16);

        } else if($sort=='giam_dan') {
            $loc = DB::table('products')->orderby('Price','desc') ->paginate(16);
        }else if($sort=='kytu_az') {
            $loc = DB::table('products')->orderby('Title','ASC') ->paginate(16);
        }else {
            $loc = DB::table('products')->orderby('Title','desc') ->paginate(16);
        }


        $category = DB::table('category') ->get();
        return view('pages.Product.loc', compact('loc', 'category', ));
    }

    public function getmuangay()
    {
        $product = DB::table('products')->orderby('id','desc')->paginate(20);
        $category = DB::table('category') ->get();
        return view('pages.muangay', compact('product','category'));
    }
     public function getgioithieu()
    {
        $category = DB::table('category') ->get();
        return view('pages.gioithieu', compact('category'));
    }
    public function gettintuc()

    {
        $category = DB::table('category') ->get();
        $blog = DB::table('blog')->orderby('id','desc')->paginate(5);
        return view('pages.tintuc', compact('blog','category' ));
    }
    public function getlienhe()
    {
        $category = DB::table('category') ->get();
        return view('pages.lienhe', compact('category'));
    }

    public function postlienhe(Request $request)
    {

        $allRequest  = $request->all();
        $name_contact  = $allRequest['ten'];
        $email_contact = $allRequest['email'];
        $title_contact = $allRequest['tieude'];
        $content_contact = $allRequest['tinnhan'];
         $dataInsert = array(
            'name_contact'  => $name_contact,
            'email_contact' => $email_contact,
            'title_contact' =>$title_contact,
            'content_contact' => $content_contact,


        );
        $insertData = DB::table('contact')->insert($dataInsert);
        $category = DB::table('category') ->get();
        return view('pages.lienhe', compact('category'));

    }
    public function postcontact_feedback(Request $request)
    {



        Mail::send('pages.Email.lienhe', [
            'name'  => $request->name,
            'content' => $request->content,

        ], function ($message) use($request) {
            $message->from('nghiantk.21it@vku.udn.vn','Shop D&N');
            $message->to( $request->email,$request->name);
            $message->subject('Liên hệ');
        });
        return view('Admin.contact_feedback');
    }

    public function getalllienhe(){

        $con = DB::table('contact')->orderby('id','desc')->paginate(5);
        return view('Admin.all_contact')->with(compact('con'));
    }

    public function  getcontact_feedback(){
        return view('Admin.contact_feedback');
    }

    public function getyeuthich()
    {
        return view('pages.product.yeuthich');
    }
        public function getthanhtoan()
    {

        return view('pages.product.thanhtoan');
    }
    public function getchitietsanpham($id)
    {
        $sanpham =DB::table('products')->where('product_id',$id)->first();
        $namecategory = DB::table('category')->where('Category_ID',$sanpham->Category_ID)->first();
        $category = DB::table('category') ->get();
        $new = DB::table('products') -> where('hot','1')->orderby('id','desc') ->paginate(12);
        return view('pages.Product.chitietsanpham', compact('category','sanpham', 'new', 'namecategory'));

    }

    public function getsanpham($id)

    {
        $category = DB::table('category') ->get();
        $sanpham = DB::table('products')-> where('Category_ID',$id)->orderby('id','desc') ->get();
        $namecategory = DB::table('category')->find($id);
        return view('pages.sanpham')->with('sanpham',$sanpham)->with('category',$category)->with('namecategory',$namecategory);
    }
    public function getaddtocart(Request $request, $id)
{
    // Kiểm tra xem người dùng đã đăng nhập hay chưa
    if (!auth()->check()) {
        return response()->json([
            'code' => 401,
            'message' => 'User not authenticated'
        ], 401);
    }

    // Kiểm tra xem sản phẩm có tồn tại trong cơ sở dữ liệu không
    $product = DB::table('products')->where('product_id', $id)->first();
    
    if (!$product) {
        return response()->json([
            'code' => 404,
            'message' => 'Product not found'
        ], 404);
    }

    // In ra log để kiểm tra
    Log::info('Product ID: ' . $product->product_id);
    
    // Lấy ID của người dùng đã đăng nhập
    $user_id = auth()->id();

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
    $cart = Cart::where('user_id', $user_id)->where('product_id', $product->product_id)->first();

    if ($cart) {
        // Tăng số lượng sản phẩm trong giỏ hàng
        $cart->quantity += 1;
        $cart->save(); // Cập nhật giỏ hàng trong cơ sở dữ liệu
        Log::info('Updated cart for product: ' . $product->product_id . ' with quantity: ' . $cart->quantity);
    } else {
        // Thêm sản phẩm mới vào giỏ hàng
        Cart::create([
            'user_id' => $user_id,
            'product_id' => $product->product_id,
            'quantity' => 1,
        ]);
        Log::info('Added new product to cart: ' . $product->product_id);
    }

    return response()->json([
        'code' => 200,
        'message' => 'Product added to cart successfully'
    ], 200);
}
public function getgiohang(Request $request)
{
   $category = DB::table('category')->get();

    // Lấy giỏ hàng của người dùng từ cơ sở dữ liệu (dựa vào user_id)
    $user_id = auth()->id();
    $carts = Cart::where('user_id', $user_id)->get();

    // Tính tổng tiền của giỏ hàng
    $total = 0;
    foreach ($carts as $cart) {
        $total += $cart->product->Price * $cart->quantity;
    }

    // Lấy thông tin các thành phố, tỉnh, và xã/phường
    $city = City::orderby('matp', 'ASC')->get();
    $province = Province::orderby('maqh', 'ASC')->get();
    $wards = Wards::orderby('xaid', 'ASC')->get();

    // Lấy phí vận chuyển (Giả sử bạn đã có bảng Freeship hoặc một bảng chứa thông tin phí vận chuyển)
    $shippingFee = 0; // Mặc định không có phí vận chuyển
    $userProvince = $request->province; // Lấy province từ request
    $userCity = $request->city; // Lấy city từ request

    if ($userCity && $userProvince) {
        // Kiểm tra phí vận chuyển theo thành phố và tỉnh
        $feeship = Freeship::where('fee_matp', $userCity)
                           ->where('fee_maqh', $userProvince)
                           ->first();

        if ($feeship) {
            $shippingFee = $feeship->fee_feeship;  // Lấy phí vận chuyển
        }
    }

    // Tổng cộng bao gồm phí vận chuyển
    $total += $shippingFee;

    // Trả về view giỏ hàng với các biến
    return view('pages.Product.giohang', compact('category', 'carts', 'city', 'province', 'wards', 'total', 'shippingFee'));
}

 

    public function postgiohang(Request $Request)
{
   if ($Request->isMethod('post')) {

        // Validate các trường nhập liệu
        $validator = Validator::make($Request->all(), [
            'wards' => 'required',
            'province' => 'required',
            'city' => 'required',
        ], [
            'province.required' => 'Trường này là trường bắt buộc',
            'wards.required' => 'Trường này là trường bắt buộc',
            'city.required' => 'Trường này là trường bắt buộc',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Lấy dữ liệu từ request
        $allRequest = $Request->all();
        $coupon = $allRequest['coupon'];
        $matp = $allRequest['city'];
        $maqh = $allRequest['province'];
        $xaid = $allRequest['wards'];

        // Kiểm tra dữ liệu tồn tại
        $wards = Wards::where('xaid', $xaid)->first();
        $province = Province::where('maqh', $maqh)->first();
        $city = City::where('matp', $matp)->first();

        // Nếu dữ liệu không hợp lệ, trả về lỗi
        if (!$wards || !$province || !$city) {
            return redirect()->back()->with('error', 'Thông tin không hợp lệ. Vui lòng kiểm tra lại.');
        }

        // Kết hợp địa chỉ và lưu vào session
        $add = implode(' ,', array($wards->name_xaphuong, $province->name_quanhuyen, $city->name_city));
        Session::put('add', $add);
        Session::save();

        // Lấy phí vận chuyển và mã giảm giá
        if ($matp) {
            $feeship = Freeship::where('fee_matp', $matp)
                ->where('fee_maqh', $maqh)
                ->where('fee_xaid', $xaid)
                ->get();

            $coupon = Coupon::where('coupon_code', $coupon)->get();

            // Lưu phí vận chuyển vào session
            foreach ($feeship as $fee) {
                Session::put('fee', $fee->fee_feeship);
                Session::save();
            }

            // Lưu mã giảm giá vào session
            foreach ($coupon as $cou) {
                Session::put('cou', $cou->coupon_number);
                Session::save();
            }

            // Chuyển sang trang thanh toán
            return Redirect::to('thanhtoan');


}


}

}
    public function getdeletecart(Request $request)
{
    $id = $request->input('id');  // Lấy ID của sản phẩm muốn xóa

    // Lấy giỏ hàng của người dùng từ cơ sở dữ liệu
    $user_id = auth()->id();  // Lấy ID người dùng đã đăng nhập

    // Tìm sản phẩm trong giỏ hàng của người dùng
    $cart = Cart::where('user_id', $user_id)->where('product_id', $id)->first();

    // Kiểm tra xem sản phẩm có tồn tại trong giỏ hàng
    if ($cart) {
        // Xóa sản phẩm khỏi giỏ hàng
        $cart->delete();
    } else {
        // Nếu không tìm thấy sản phẩm, trả về thông báo lỗi
        return response()->json([
            'code' => 404,
            'message' => 'Product not found in cart'
        ], 404);
    }

    // Lấy giỏ hàng mới sau khi đã xóa sản phẩm
    $carts = Cart::where('user_id', $user_id)->get();

    // Kiểm tra nếu giỏ hàng trống
    if ($carts->isEmpty()) {
        return response()->json([
            'code' => 200,
            'message' => 'Cart is empty',
            'cart_component' => view('pages.Product.giohang')->with('carts', $carts)->render()
        ], 200);
    }

    // Tính tổng tiền giỏ hàng mới
    $total = 0;
    foreach ($carts as $cart) {
        $total += $cart->product->Price * $cart->quantity;
    }

    // Trả về dữ liệu giỏ hàng cập nhật và tổng tiền
    return response()->json([
        'code' => 200,
        'message' => 'Product removed from cart successfully',
        'cart_component' => view('pages.Product.giohang', compact('carts', 'total'))->render()
    ], 200);
}
}