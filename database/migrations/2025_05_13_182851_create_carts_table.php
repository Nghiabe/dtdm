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
    Schema::table('carts', function (Blueprint $table) {
        // Xóa khóa ngoại trước khi thay đổi kiểu dữ liệu
        $table->dropForeign(['product_id']);

        // Thay đổi kiểu dữ liệu của cột product_id
        $table->unsignedBigInteger('product_id')->change();

        // Thêm lại khóa ngoại sau khi thay đổi kiểu dữ liệu
        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('carts', function (Blueprint $table) {
        // Xóa khóa ngoại trước khi thay đổi kiểu dữ liệu
        $table->dropForeign(['product_id']);

        // Thay đổi lại kiểu dữ liệu của product_id
        $table->integer('product_id')->change();

        // Thêm lại khóa ngoại sau khi thay đổi kiểu dữ liệu
        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
    });
}

};
