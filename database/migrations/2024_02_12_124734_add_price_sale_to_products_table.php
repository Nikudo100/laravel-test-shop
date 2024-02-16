<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('priceSale', 10, 2)->after('price')->nullable();
        });

        // Обновляем priceSale для каждого продукта
        $products = Product::all();

        foreach ($products as $product) {
            $product->priceSale = $product->price * (1 - ($product->discount / 100));
            $product->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('priceSale');
        });
    }
};
