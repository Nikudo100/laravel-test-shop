<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('discount')->after('price')->nullable();
        });

        // Получаем все продукты
        $products = DB::table('products')->get();

        // Обновляем каждый продукт с уникальной скидкой от 5 до 25%
        foreach ($products as $product) {
            $discount = rand(5, 25);
            DB::table('products')->where('id', $product->id)->update(['discount' => $discount]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('discount');
        });
    }
};
