<div class="container my-1">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bi bi-cart3"></i> Корзина <span
                        class="badge text-bg-danger">@if (session('cart-items')) {{ count(session('cart-items')) }} @endif</span>
                </button>

                <div class="dropdown-menu">
                    <div class="row total-header-section">
                        @php $total = 0 @endphp
                        @if (session('cart-items'))
                        @foreach (session('cart-items') as $item)
                            @php $total += $item['price'] * $item['quantity'] @endphp
                        @endforeach
                        @endif
                        <div class="col-lg-12 col-sm-12 col-12 total-section text-right">
                            <p>Итого: <span class="text-info">Руб {{ $total }}</span></p>
                        </div>
                    </div>
                    @if (session('cart-items'))
                        @foreach (session('cart-items') as $item)
                            <div class="row cart-detail">
                                <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                                    <img src="{{ $item['image'] }}" />
                                </div>
                                <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                                    <p>{{ $item['product_name'] }}</p>
                                    <span class="price text-info"> {{ $item['price'] }} Руб</span> <span class="count">
                                        Кол-во:{{ $item['quantity'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                            <a href="{{route('cart') }}" class="btn btn-primary btn-block">Посмотреть все</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


