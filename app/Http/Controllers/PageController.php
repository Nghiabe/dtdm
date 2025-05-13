<?php

namespace App\Http\Controllers;

use App\Models\Product as ModelsProduct;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model\Product;
use DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;
use App\Models\City;
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
    public function getaddtocart($id)
    {
        $product = DB::table('products')->where('product_id', $id)->first();

    // Kiểm tra nếu sản phẩm tồn tại
    if (!$product) {
        return response()->json([
            'code' => 404,
            'message' => 'Product not found'
        ], 404);
    }

    // Lấy giỏ hàng từ cookie (nếu có)
    $cart = Cookie::get('cart') ? json_decode(Cookie::get('cart'), true) : [];

    // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
    if (isset($cart[$id])) {
        // Tăng số lượng sản phẩm trong giỏ hàng
        $cart[$id]['quantity'] = $cart[$id]['quantity'] + 1;
    } else {
        // Thêm sản phẩm mới vào giỏ hàng
        $cart[$id] = [
            'name' => $product->Title,
            'price' => $product->Discount,
            'quantity' => 1,
            'image' => $product->Thumbnail
        ];
    }

    // Lưu giỏ hàng vào cookie (thời gian lưu cookie là 30 ngày)
    Cookie::queue('cart', json_encode($cart), 60 * 24 * 30); // cookie sẽ tồn tại trong 30 ngày

    return response()->json([
        'code' => 200,
        'message' => 'Product added to cart successfully'
    ], 200);
    }

    public function getgiohang()
    {
        $cart = Cookie::get('cart') ? json_decode(Cookie::get('cart'), true) : [];

    // Lấy danh mục sản phẩm
    $category = DB::table('category')->get();

    // Trả về view giỏ hàng với dữ liệu giỏ hàng từ cookie
    return view('pages.Product.giohang', compact('category', 'cart')); 
    }

    public function getdeletecart(Request $request)
    {
        // Kiểm tra id sản phẩm cần xóa khỏi giỏ hàng
        if ($request->id) {
            $cart = Cookie::get('cart') ? json_decode(Cookie::get('cart'), true) : [];

            // Xóa sản phẩm khỏi giỏ hàng
            unset($cart[$request->id]);

            // Lưu lại giỏ hàng đã cập nhật vào cookie
            Cookie::queue('cart', json_encode($cart), 60 * 24 * 30);

            // Trả về giỏ hàng mới cập nhật
            $category = DB::table('category')->get();
            $dete = view('pages.Product.giohang', compact('cart', 'category'))->render();

            return response()->json(['cart_component' => $dete, 'code' => 200], 200);
        }

        return response()->json(['code' => 404, 'message' => 'Product not found in cart'], 404);
    }

    public function postgiohang(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
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

            // Lấy thông tin địa chỉ
            $allRequest = $request->all();
            $coupon = $allRequest['coupon'];
            $matp = $allRequest['city'];
            $maqh = $allRequest['province'];
            $xaid = $allRequest['wards'];

            // Xử lý thông tin địa chỉ và phí vận chuyển
            $wards = Wards::where('xaid', $allRequest['wards'])->first();
            $province = Province::where('maqh', $allRequest['province'])->first();
            $city = City::where('matp', $allRequest['city'])->first();
            $add = implode(' ,', array($wards->name_xaphuong, $province->name_quanhuyen, $city->name_city));

            // Lưu địa chỉ vào session
            Session::put('add', $add);
            Session::save();

            // Lấy phí vận chuyển và coupon
            if ($matp) {
                $feeship = Freeship::where('fee_matp', $matp)->where('fee_maqh', $maqh)->where('fee_xaid', $xaid)->get();
                $coupon = Coupon::where('coupon_code', $coupon)->get();

                foreach ($feeship as $key => $fee) {
                    Session::put('fee', $fee->fee_feeship);
                    Session::save();
                }

                foreach ($coupon as $key => $cou) {
                    Session::put('cou', $cou->coupon_number);
                    Session::save();
                }

                return Redirect::to('thanhtoan');
            }
        }
    }
}