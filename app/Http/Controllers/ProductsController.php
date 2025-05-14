<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;

class ProductsController extends Controller
{
    public function __construct() {
	$this->middleware('auth');
}
    public function getcheckout(Request $request)

    {

        if ($request->Payments == 'Direct') {
        // Validate thông tin thanh toán
        $validator = Validator::make($request->all(), [
            'FullName' => 'required|max:100',
            'Address' => 'required|max:200',
            'phone' => 'required|min:10|max:10',
        ], [
            'FullName.required' => 'Họ và tên là trường bắt buộc',
            'Address.required' => 'Địa chỉ là trường bắt buộc',
            'phone.required' => 'Số điện thoại là trường bắt buộc',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Lấy thông tin giỏ hàng, phí vận chuyển, và mã giảm giá
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $carts = session()->get('cart');
        $fee = session()->get('fee');
        $cou = session()->get('cou');
        $id_user = Auth::guard('auth')->user()->id;
        $Name = Auth::guard('auth')->user()->Name;
        $allRequest = $request->all();
        $FullName = $allRequest['FullName'];
        $email = Auth::guard('auth')->user()->Email;
        $adr = session()->get('add');
        $Address = $allRequest['Address'];
        $phone = $allRequest['phone'];
        $note = $allRequest['note'];
        $add = implode(' ,', array($Address, $adr));
        $date = date("Y-m-d");

        // Kiểm tra số lượng sản phẩm trong kho
        foreach ($carts as $key => $item) {
            $user = DB::table('products')->where('product_id', $key)->first();
            $quantity = $item['quantity'];
            if ($quantity > $user->quantity) {
                Session::flash('soluong', 'Hiện tại số lượng kho còn thấp. Vui  lòng giảm số lượng thấp hơn ' . $user->quantity . '. Xin lỗi vì sự bất tiện này');
                return redirect()->back()->withInput();
            }
        }

        // Lưu thông tin khách hàng vào cơ sở dữ liệu
        if ($customer = Customer::create([
            'id_user' => $id_user,
            'FullName' => $FullName,
            'email' => $email,
            'Address' => $add,
            'phone' => $phone,
            'note' => $note,
            'Name' => $Name
        ])) {
            $c_id = $customer->id;
        }

        // Lưu đơn hàng vào cơ sở dữ liệu
        if ($order = Order::create([
            'customer_id' => $c_id,
            'order_note' => $request->note,
            'ship' => $fee,
            'coupon' => $cou,
            'order_status' => '0',
            'order_date' => $date,
        ])) {
            $order_id = $order->id;

            // Lưu chi tiết đơn hàng vào cơ sở dữ liệu
            foreach ($carts as $key => $item) {
                $quantity = $item['quantity'];
                $price = $item['price'];
                $name = $item['name'];
                $img = $item['image'];
                $product_id = $key;
                $pr = DB::table('products')->where('product_id', $key)->first();
                $dataInsertToDatabase = array(
                    'order_id' => $order_id,
                    'product_id' => $product_id,
                    'price' => $price,
                    'Name' => $name,
                    'Img' => $img,
                    'quantity' => $quantity,
                    'date' => $date,
                    'Category_id' => $pr->Category_ID,
                );
                DB::table('order_details')->insert($dataInsertToDatabase);
            }

            // Sau khi lưu đơn hàng, chuyển đến trang thành công
            return Redirect::to('thanhcong')->with('id', $order_id);
        }
    } else {
        // Xử lý phương thức thanh toán không phải trực tiếp (ATM hoặc các phương thức khác)
        Session::flash('noatm', 'Phương thức thanh toán online chưa được áp dụng');
        }


    }
    public function getthanhcong()

    {
        $category = DB::table('category') ->get();

        return view('pages.Product.thanhcong',compact('category', ) );

    }
    public function all_custommer(){
        $cus = Customer::orderby('id','DESC')->paginate(5);
        return view('Admin.all_custommer')->with(compact('cus'));
    }

    public function getdonmua()

    {
        $id_user =Auth::guard('auth')->user()->id;
        $customer = Customer::where('id_user',$id_user)->get();

        $category = DB::table('category') ->get();
    //     foreach($customer as $key => $ord){

    //         $order = Order::where('customer_id',$customer->id)->get();
    // }
    // foreach($order as $key => $od){
    //     $order_details = OrderDetail::where('order_id',$od->id)->first();
    // }
    // dd($order_details);
        return view('pages.Product.donmua')->with('category',$category);
    }


}
