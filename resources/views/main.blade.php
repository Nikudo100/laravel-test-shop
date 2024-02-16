@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <main>
        <div class="container">
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3 product" data-id="{{ $product->id }}">
                        <article class="card mt-5 overflow-hidden">
                            <div class="img-wrap">
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                            </div>
                            <h3 class="fs-6 mb-3">
                                {{ $product->name }}
                            </h3>
                            <p class="fw-bold fs-5 mb-0">
                                Цена: <del>{{ $product->price }}</del><br>
                                Цена со скидкой: {{ $product->priceSale }} <br>
                                Cкидка: {{ $product->discount }}%
                            </p>
                            <p>Бонус: {{ $product->bonus }}</p>
                            <button class="btn-buy btn btn-primary">
                                В корзину
                            </button>
                            <!-- TODO: этот блок появлется после нажатия кнопки "В корзину" -->
                            <div class="count-button" style="display: none;">
                                <div class="count-button-in d-flex align-items-center gap-3 m-auto w-fit-content">
                                    <button class="btn btn-outline-primary">-</button>
                                    <span>1</span>
                                    <button class="btn btn-outline-primary">+</button>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
            <div class="pagination justify-content-center mt-4 mb-3">
                {{ $products->links() }}
            </div>
        </div>
    </main>
@endsection
