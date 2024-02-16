@extends('layouts.app')

@section('title', 'Главная')

@section('content')

<main>
    <div class="container text-center">
        <h1 class="text-center mt-5">
            Ваш номер заказа {{ $cart->id }}. <br>
            Cумма к оплате со скидкой {{ $cart->total_price_sale }}. <br>
            Спасибо за заказ!<br>
        </h1>
        <a href="/"
        class="bg-primary fs-6 text-light m-10 rounded-pill p-2 px-4 text-decoration-none">Перейти в
        каталог</a>
    </div>
</main>

@endsection