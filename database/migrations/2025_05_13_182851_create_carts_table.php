<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id(); // Tạo cột id tự tăng
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Khóa ngoại với bảng users
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Khóa ngoại với bảng products
            $table->integer('quantity')->default(1); // Số lượng sản phẩm
            $table->timestamps(); // Tạo cột created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
};
