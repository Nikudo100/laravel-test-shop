@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <main>
        {{-- {{dd($cart)}} --}}
        <div class="container text-center">
            @if ($cart)
                <h1 class="text-center mt-5">Корзина</h1>
                <div class="row mb-4">
                    <div class="col-12 col-lg-8">
                        @foreach ($cart->cartElements as $el)
                            <article class="card mt-4 overflow-hidden">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="img-wrap">
                                            <img class="w-100" src="{{ asset($el->product->image) }}"
                                                alt="{{ $el->product->name }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-8 d-flex align-items-center">
                                        <div class="p-3">
                                            <h3 class="fs-6 mb-2">
                                                {{ $el->product->name }}
                                            </h3>
                                            <p>Кол-во - {{ $el->quantity }} шт.
                                            </p>
                                            <p class="fw-bold fs-6 m-0">
                                                цена без скидки - {{ $el->product->price }} ₽ / шт.
                                            </p>
                                            <p class="fw-bold fs-6 m-0">
                                                с учётом скидки <span>{{ $el->product->discount }}%</span> -
                                                {{ $el->product->priceSale }} ₽ / шт.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                        {{-- <article class="card mt-4 overflow-hidden">
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="img-wrap">
                                    <img class="w-100" src="/images/pic-2.webp" alt="Изображение товара">
                                </div>
                            </div>
                            <div class="col-12 col-sm-8 d-flex align-items-center">
                                <div class="p-3">
                                    <h3 class="fs-6 mb-2">
                                        Шоссейный велосипед BMC Roadmachine 01 Five Ultegra Di2 (2023)
                                    </h3>
                                    <p>Кол-во - 3 шт.
                                    </p>
                                    <p class="fw-bold fs-6 m-0">
                                        цена без скидки - 773 280 ₽ / шт.
                                    </p>
                                    <p class="fw-bold fs-6 m-0">
                                        с учётом скидки <span>5%</span> - 734 616 ₽ / шт.
                                    </p>
                                </div>
                            </div>
                        </div>
                        </article> --}}
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card p-3 mt-4">
                            <p class="fs-4">Общая сумма заказа:</p>
                            <p class="fw-bold">{{ $cart->total_price }} ₽</p>
                            <p class="fs-4">Общая сумма заказа c учётом скидкидок <span>{{ $cart->total_discount }}%</span>:</p>
                            <p class="fw-bold">{{ $cart->total_price_sale }} ₽</p>
                            <p class="fw-bold">Бонусов зачислится {{ $cart->total_bonus }}</p>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="1" id="use-bonus" name="use-bonus">
                                <label class="form-check-label mb-3" for="use-bonus">Списать бонусы</label>
                                <p>*если списать бонусы, то текущие бонусы с корзины не будут зачислены</p>
                            </div>
                            <btn href="{{ route('cart.close') }}" class="card-close btn btn-primary">Заказать</btn>
                        </div>
                    </div>
                </div>
            @else
                <h1 class="text-center mt-5">Корзина пуста</h1>
                <a href="/"
                    class="bg-primary fs-6 text-light m-10 rounded-pill p-2 px-4 text-decoration-none">Перейти в
                    каталог</a>
            @endif
        </div>
    </main>
@endsection