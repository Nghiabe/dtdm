<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;  // Để sử dụng các tính năng của Laravel Factory

    // Đặt tên bảng (nếu tên bảng không phải là số nhiều của tên model)
    protected $table = 'carts';

    // Các trường có thể được gán giá trị đại trà (mass assignable)
    protected $fillable = [
        'user_id',     // Id của người dùng
        'product_id',  // Id của sản phẩm
        'quantity',    // Số lượng sản phẩm trong giỏ
    ];

    // Quan hệ với bảng User: Một giỏ hàng thuộc về một người dùng
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với bảng Product: Một giỏ hàng thuộc về một sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
