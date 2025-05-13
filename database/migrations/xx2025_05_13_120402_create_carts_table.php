// database/migrations/xxxx_xx_xx_xxxxxx_create_carts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Quan hệ với bảng users
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Quan hệ với bảng products
            $table->integer('quantity')->default(1); // Số lượng sản phẩm
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
