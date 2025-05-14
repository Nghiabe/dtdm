<?php
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\AdminController;
Use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\OrderController;
Use App\Http\Controllers\ProductController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DeliveryController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|


*/
Route::group(['prefix' => 'checkout'], function () {
    Route::get('/thanhtoan', [App\Http\Controllers\ProductsController::class, 'getcheckout'])->name('checkout');
    Route::post('/thanhtoan', [App\Http\Controllers\ProductsController::class, 'checkout'])->name('checkout');
    Route::post('/tinhphi', [App\Http\Controllers\PageController::class, 'tinhphi'])->name('tinhphi');
    Route::get('/thanhcong', [App\Http\Controllers\ProductsController::class, 'getthanhcong'])->name('thanhcong');
});
Route::get('/thanhtoan', [App\Http\Controllers\ProductsController::class, 'getcheckout'])->name('thanhtoan');
Route::get('/thanhcong', [App\Http\Controllers\ProductsController::class, 'getthanhcong'])->name('thanhcong');
Route::get('/add-staff', [App\Http\Controllers\UsersController::class, 'add_staff'])->name('add_staff');
Route::post('/savestaff', [App\Http\Controllers\UsersController::class, 'savestaff'])->name('savestaff');
Route::get('/all_staff', [App\Http\Controllers\UsersController::class, 'all_staff']);

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'admin'])->name('admin');

Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'show_dashboard']);


Route::get('/add-category-product', [App\Http\Controllers\CategoryProduct::class, 'add_category_product']);
Route::get('/all-category-product', [App\Http\Controllers\CategoryProduct::class, 'all_category_product']);
Route::get('/edit-category-product/{category_product_id}', [App\Http\Controllers\CategoryProduct::class, 'edit_category_product']);
Route::get('/delete-category-product/{category_product_id}', [App\Http\Controllers\CategoryProduct::class, 'delete_category_product']);
Route::post('/save-category-product', [App\Http\Controllers\CategoryProduct::class, 'save_category_product']);
Route::post('/update-category-product/{category_product_id}', [App\Http\Controllers\CategoryProduct::class, 'update_category_product']);

Route::get('/add-product', [App\Http\Controllers\ProductController::class, 'add_product']);
Route::get('/all-product', [App\Http\Controllers\ProductController::class, 'all_product']);
Route::get('/edit-product/{product_id}', [App\Http\Controllers\ProductController::class, 'edit_product']);
Route::get('/delete-product/{product_id}', [App\Http\Controllers\ProductController::class, 'delete_product']);
Route::post('/save-product', [App\Http\Controllers\ProductController::class, 'save_product']);
Route::post('/update-product/{product_id}', [App\Http\Controllers\ProductController::class, 'update_product']);

//Order
// Route::get('/delete-order/{order_code}', [App\Http\Controllers\ProductController::class, 'order_code']);
// Route::get('/print-order/{checkout_code}', [App\Http\Controllers\ProductController::class, 'print_order']);
Route::get('/manage-order', [App\Http\Controllers\OrderController::class, 'manage_order'])->name('manage-order');
Route::get('/view-order/{id}', [App\Http\Controllers\OrderController::class, 'view_order']);
Route::get('/Receipt/{id}', [App\Http\Controllers\OrderController::class, 'receipt']);
Route::get('/handle/{id}', [App\Http\Controllers\OrderController::class, 'handle_product']);

//Coupon
Route::get('/unset-coupon', [App\Http\Controllers\CouponController::class, 'unset_coupon']);
Route::get('/insert-coupon', [App\Http\Controllers\CouponController::class, 'insert_coupon']);
Route::get('/delete-coupon/{coupon_id}', [App\Http\Controllers\CouponController::class, 'delete_coupon']);
Route::get('/list-coupon', [App\Http\Controllers\CouponController::class, 'list_coupon']);
Route::post('/insert-coupon-code', [App\Http\Controllers\CouponController::class, 'insert_coupon_code']);


//Delivery
Route::get('/delivery', [App\Http\Controllers\DeliveryController::class, 'delivery']);
Route::post('/select-delivery',[App\Http\Controllers\DeliveryController::class, 'select_delivery']);
Route::post('/insert-delivery',[App\Http\Controllers\DeliveryController::class, 'insert_delivery']);
Route::get('/list-delivery',[App\Http\Controllers\DeliveryController::class, 'list_delivery']);
Route::get('/delete-delivery/{fee_id}',[App\Http\Controllers\DeliveryController::class, 'delete_delivery']);
Route::post('/update-delivery',[App\Http\Controllers\DeliveryController::class, 'update_delivery']);

Route::get('/all-custommer', [App\Http\Controllers\ProductsController::class, 'all_custommer']);

Route::get('/all-contact', [App\Http\Controllers\PageController::class, 'getalllienhe'])->name('alllienhe');
Route::get('/contact-feedback', [App\Http\Controllers\PageController::class, 'getcontact_feedback'])->name('contact_feedback');
Route::post('/contact-feedback', [App\Http\Controllers\PageController::class, 'postcontact_feedback'])->name('contact_feedback');


/*........User..........*/
Route::get('/dangki', [App\Http\Controllers\UsersController::class, 'getsignup'])->name('showsignup');
Route::post('/dangki', [App\Http\Controllers\UsersController::class, 'signup'])->name('signup');

Route::get('/dangnhap', [App\Http\Controllers\UsersController::class, 'getsignin'])->name('showsignin');
Route::post('/dangnhap', [App\Http\Controllers\UsersController::class, 'signin'])->name('signin');

Route::get('/dangxuat', [App\Http\Controllers\UsersController::class, 'logout'])->name('logout');

Route::get('/login_facebook/{social}',[App\Http\Controllers\UsersController::class,'getInfo'])->name('fba');
Route::get('/dangnhap/callback/{social}',[App\Http\Controllers\UsersController::class,'checkInfo']);

Route::get('/login_google/{so}',[App\Http\Controllers\UsersController::class,'getInfoGG'])->name('fjh');
Route::get('/dangnhap/callback/{so}',[App\Http\Controllers\UsersController::class,'checkInfoGG']);

Route::get('/', [App\Http\Controllers\PageController::class, 'getindex'])->name('index');

Route::get('/gioithieu', [App\Http\Controllers\PageController::class, 'getgioithieu'])->name('gioithieu');
Route::get('/donmua', [App\Http\Controllers\ProductsController::class, 'getdonmua'])->name('donmua');
Route::get('/sanpham', [App\Http\Controllers\PageController::class, 'getsanpham'])->name('sanpham');

Route::get('/muangay', [App\Http\Controllers\PageController::class, 'getmuangay'])->name('muangay');

Route::get('/lienhe', [App\Http\Controllers\PageController::class, 'getlienhe'])->name('lienhe');
Route::post('/lienhe', [App\Http\Controllers\PageController::class, 'postlienhe'])->name('lienhe');

Route::get('/tintuc', [App\Http\Controllers\PageController::class, 'gettintuc'])->name('tintuc');

Route::get('/giohang', [App\Http\Controllers\PageController::class, 'getgiohang'])->name('giohang');
Route::post('/giohang', [App\Http\Controllers\PageController::class, 'postgiohang'])->name('giohang');

Route::get('/yeuthich', [App\Http\Controllers\PageController::class, 'getyeuthich'])->name('yeuthich');

Route::get('/view{id}', [App\Http\Controllers\PageController::class, 'getchitietsanpham'])->name('chitietsanpham');

Route::get('/{id}', [App\Http\Controllers\PageController::class, 'getsanpham'])->name('sanpham');

// Route cho việc thêm sản phẩm vào giỏ hàng (addtocart)
// Controller
Route::post('/sanpham/addtocart/{id}', [App\Http\Controllers\PageController::class, 'getaddtocart']);
// Route::get('/sanpham/addtocart/{id}', [PageController::class, 'getaddtocart'])->name('addtocart');
Route::post('/sanpham/addtocart/{id}', [App\Http\Controllers\PageController::class, 'getaddtocart'])->name('addtocart');
// Route cho việc xóa sản phẩm khỏi giỏ hàng (delete-cart)
Route::post('/sanpham/delete-cart', [App\Http\Controllers\PageController::class, 'getdeletecart'])->name('deletecart');

// Route cho việc cập nhật giỏ hàng (update-cart)
Route::post('/sanpham/update-cart', [App\Http\Controllers\PageController::class, 'getdupdatecart'])->name('updatecart');


Route::post('/tinhphi', [App\Http\Controllers\PageController::class, 'tinhphi'])->name('tinhphi');

Route::post('/timkiem', [App\Http\Controllers\PageController::class, 'gettimkiem'])->name('timkiem');

Route::post('/loc', [App\Http\Controllers\PageController::class, 'getloc'])->name('loc');



Route::get('/thanhcong', [App\Http\Controllers\ProductsController::class, 'getthanhcong'])->name('thanhcong');


Route::get('/check-env', function () {
    return [
        'DB_HOST (env)' => env('DB_HOST'),
        'DB_HOST (config)' => config('database.connections.mysql.host'),
        'DB_DATABASE' => config('database.connections.mysql.database'),
        'DB_USERNAME' => config('database.connections.mysql.username'),
    ];
});








