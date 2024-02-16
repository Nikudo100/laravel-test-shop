<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('name');
            $table->string('bonus');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
        $faker = Faker::create();
        // Inserting sample data into the table
        for ($i = 0; $i < 25; $i++) {
            DB::table('products')->insert([
                'image' => 'images/pic-' . random_int(1, 4) . '.webp',
                'name' => $faker->name(),
                'price' => rand(25, 250),
                'bonus' => rand(10, 100),
                'created_at' => now(),
                'updated_at' => now(),  
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
