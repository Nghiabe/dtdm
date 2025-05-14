<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Dotenv\Validator as DotenvValidator;
use Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Social;
use App\Models\Staff;
use Socialite;

class UsersController extends Controller
{

//
public function getsignup()
{
    $category = DB::table('category') ->get();
    return view('auth.register',compact('category'));
}

public function signup(Request $Request)
{

    if ($Request->isMethod('post')){

        $validator = Validator ::make($Request->all(),[
            'name'=>'required|min:6|max:30|alpha',
            'email'=>'required|email',
            'password'=>'required|confirmed|min:6|max:30',
        ], [
            'name.required' => 'Tên tài khoản là trường bắt buộc',
            'name.email' => 'Name không đúng định dạng',
            'email.required' => 'Email là trường bắt buộc',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Mật khẩu là trường bắt buộc',
            'password.min' => 'Mật khẩu phải chứa ít nhất 8 ký tự',
			'password.confirmed' => 'Xác nhận mật khẩu không đúng',
        ]);
        if($validator->fails()){
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();

        }
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $allRequest  = $Request->all();
        $Name  = $allRequest['name'];
        $Email = $allRequest['email'];
        $Password = $allRequest['password'];


        $dataInsert = array(
            'Name'  => $Name,
            'Email' => $Email,
            'password' => Hash::make($Password),
            'level' => '3',


        );
        $insertData = DB::table('user')->insert($dataInsert);


        //Kiểm tra Insert để trả về một thông báo
        if ($insertData) {
            Session::flash('success', 'Đăng kí  thành công!');
        }else {
            Session::flash('error', 'Đăng kí thất bại!');
        }
        return redirect('dangnhap');

    }



}
public function signin(Request $Request)
{

   // Log khi bắt đầu xử lý đăng nhập
    Log::info('Attempting to login with email: ' . $Request->email);

    $validator = Validator::make($Request->all(), [
        'email' => 'required|email',
        'password' => 'required',
    ], [
        'email.required' => 'Email là trường bắt buộc',
        'email.email' => 'Email không đúng định dạng',
        'password.required' => 'Mật khẩu là trường bắt buộc',
    ]);

    if ($validator->fails()) {
        Log::warning('Validation failed for email: ' . $Request->email);  // Log khi validation thất bại
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $remember = $Request->has('remember');  // Kiểm tra "remember me"

    // Mảng thông tin đăng nhập
    $arr = [
        'email' => $Request->email, // Chắc chắn rằng 'email' nhỏ
        'password' => $Request->password
    ];

    // Kiểm tra đăng nhập
    if (Auth::attempt($arr, $remember)) {
        // Đăng nhập thành công
        Log::info('User logged in successfully: ' . $Request->email);  // Log khi đăng nhập thành công

        // Kiểm tra phân quyền
        if (Auth::user()->level == 1 || Auth::user()->level == 2) {
            Log::warning('User with email ' . $Request->email . ' has restricted access.');  // Log khi người dùng bị cấm
            return redirect()->route('admin')->with('message', 'Tài khoản đã bị khóa');
        }
        if (Auth::user()->level != 3) {
            Log::warning('User with email ' . $Request->email . ' has insufficient access level.');  // Log khi người dùng có level không hợp lệ
            return redirect()->route('signin')->with('message', 'Tài khoản không có quyền truy cập');
        }

        // Lưu thông tin người dùng vào session
        Session::flash('account_user', 'Xin chào ');

        return redirect()->route('index');
    } else {
        // Nếu đăng nhập thất bại
        Log::warning('Login failed for email: ' . $Request->email);  // Log khi đăng nhập thất bại
        Session::flash('error', 'Email hoặc mật khẩu không đúng!');
        return redirect('dangnhap');
		}

}
public function add_staff(){


    return view('admin.add_staff');
}
public function savestaff (Request $Request)
{
    if ($Request->isMethod('post')){

        $validator = Validator ::make($Request->all(),[
            'staff_name'=>'required|min:6|max:30|alpha',
            'staff_email'=>'required|email',
            'staff_pass'=>'required|min:6|max:30',
            'staffname'=>'required|max:100',
            'staff_address'=>'required|max:200',
            'staff_phone'=>'required|min:10|max:10',
            'staff_position'=>'required|max:200',
        ], [
            'staff_name.required' => 'Tên tài khoản là trường bắt buộc',
                    'staff_name.email' => 'Name không đúng định dạng',
                    'staff_email.required' => 'Email là trường bắt buộc',
                    'staff_email.email' => 'Email không đúng định dạng',
                    'staff_pass.required' => 'Mật khẩu là trường bắt buộc',
                    'staff_pass.min' => 'Mật khẩu phải chứa ít nhất 8 ký tự',
                    'staffname.required' => 'Họ và tên là trường bắt buộc',
                'staff_address.required' => 'Địa chỉ là trường bắt buộc',
                'staff_position.required' => 'Chức vụ  là trường bắt buộc',


                'staff_phone.required' => 'Số điện thoại là trường bắt buộc',

        ]);

        if($validator->fails()){
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();

        }

        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $allRequest  = $Request->all();
        $Name  = $allRequest['staff_name'];
        $Email = $allRequest['staff_email'];
        $Password = $allRequest['staff_pass'];
        $staff_name = $allRequest['staffname'];
        $staff_phone = $allRequest['staff_phone'];
        $staff_address = $allRequest['staff_address'];
        $staff_position = $allRequest['staff_position'];

        if ($user = User::create([
            'Name'  => $Name,
            'Email' => $Email,
            'Password' => Hash::make($Password),
            'level' => '2',
        ])) {
            $u_id = $user ->id;
        }
        $orang = Staff::create([
            'staff_name' => $staff_name ,
            'staff_phone' => $staff_phone,
            'staff_address' => $staff_address,
            'staff_position' => $staff_position,
            'id_user' => $u_id

        ]);


        //Kiểm tra Insert để trả về một thông báo
        if ($orang) {
            Session::flash('success', 'Đăng kí  thành công!');
        }else {
            Session::flash('error', 'Đăng kí thất bại!');
        }
        return redirect()->route('add_staff');


    }



}

public function all_staff(){
    $staff = Staff::orderby('id','DESC')->paginate(5);
    return view('Admin.all_staff')->with(compact('staff'));
}

public function getsignin()
    {
        $category = DB::table('category') ->get();
        return view('auth.login',compact('category') );
    }
    public function logout()
    {
        Auth:: logout();
        return redirect()->route('index');


    }

    public function getInfo($social){
    config(['services.facebook.redirect' => env('FACEBOOK_CLIENT_REDIRECT')]);
        return Socialite::driver($social)->redirect();
    }

    public function checkInfo($social){
        config(['services.facebook.redirect' => env('FACEBOOK_CLIENT_REDIRECT')]);
        $provider = Socialite::driver('facebook')->user();

         $account = Social::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();

          if($account!=NULL){
            //login in vao trang quan tri
            $account_name = User::where('id',$account->id)->first();
            Session::put('Email',$account_name->email);
            Session::put('password',$account_name->password);
            Auth::loginUsingId($account_name->id);


            return redirect()->route('index')->with('message', 'Đăng nhập thành công');
            // return redirect('/')->with('message', 'Đăng nhập thành công');
        }elseif($account==NULL){

            $hieu = new Social([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);

                $orang = User::create([
                    'Name' => $provider->getName(),
                    'Email' => $provider->getEmail(),
                    'Password' => Hash::make('123456'),
                    'level' => 3

                ]);



            }

            $hieu->login()->associate($orang);
            $hieu->save();
            $account_new = User::where('id',$orang->id)->first();
            Session::put('Email',$account_new->Email);
            Session::put('id',$account_new->id);
            Auth::loginUsingId($account_new->id);



            return redirect()->route('index')->with('message', 'Đăng nhập thành công');


    }
    public function getInfoGG($so){
        config(['services.google.redirect' => env('GOOGLE_CLIENT_REDIRECT')]);

        return Socialite::driver($so)->redirect();

        }
        public function checkInfoGG(){
            config(['services.google.redirect' => env('GOOGLE_CLIENT_REDIRECT')]);
            $user = Socialite::driver('google')->stateless()->user();
    dd($user);

             $account = Social::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
            // dd($account);
              if($account!=NULL){
                //login in vao trang quan tri
                $account_name = User::where('id',$account->id)->first();
                Session::put('Email',$account_name->email);
                Session::put('password',$account_name->password);
                Auth::loginUsingId($account_name->id);

                // return redirect()->route('home');

                return redirect()->route('index')->with('message', 'Đăng nhập thành công');
                // return redirect('/')->with('message', 'Đăng nhập thành công');
            }elseif($account==NULL){

                $hieu = new Social([
                    'provider_user_id' => $provider->getId(),
                    'provider' => 'facebook'
                ]);

                // $orang = User::where('Email',$provider->getEmail())->first();
                // // dd($orang);

                // if(!$orang){
                //     $dataInsert = array(
                //         'Name'  => $provider->getName(),
                //         'Email' => $provider->getEmail(),
                //         'password' => bcrypt('*******'),
                //         'level' => '3',


                //     );
                    // $orang = DB::table('user')->insert($dataInsert);

                    $orang = User::create([
                        'Name' => $provider->getName(),
                        'Email' => $provider->getEmail(),
                        'Password' => Hash::make('123456'),
                        'level' => 3

                    ]);



                }

                //  if (Auth::attempt($orang)) {
                //     if(Auth::user()->level!=3){
                //      return redirect()->route('signin')->with('message', 'taif khoarn ddax bij khoaa');
                //     }
                //  //    if(Auth::user()->role==1){
                //  //     return redirect()->route('trangchu')->with('message', 'taif khoarn ddax bij khoaa')
                //  //    }


                //  Session::flash('account_user', 'Xin chào ');
                //  return redirect()->route('index');

                //  }else{
                //      // Kiểm tra không đúng sẽ hiển thị thông báo lỗi
                //      Session::flash('error', 'Email hoặc mật khẩu không đúng!');
                //      return redirect('dangnhap');
                //  }

                // Auth::login(User::find($orang),true);

                $hieu->login()->associate($orang);
                $hieu->save();
                $account_new = User::where('id',$orang->id)->first();
                Session::put('Email',$account_new->Email);
                Session::put('id',$account_new->id);
                Auth::loginUsingId($account_new->id);

                // return redirect()->route('home');

                return redirect()->route('index')->with('message', 'Đăng nhập thành công');


        }



}

