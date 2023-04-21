@extends('layouts.app')

@section('content')
<div class="container">
    <table id="cart" class="table table-hover table-condensed">
        <thead>
            <tr>
                <th style="width:50%">Товар</th>
                <th style="width:10%">Цена</th>
                <th style="width:8%">Кол-во</th>
                <th style="width:22%" class="text-center">Подитог</th>
                <th style="width:10%"></th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0 @endphp
            @if (session('cart-items'))
                @foreach (session('cart-items') as $details)
                    @php $total += $details['price'] * $details['quantity'] @endphp
                    <tr data-id="{{ $details['product_id'] }}">
                        <td data-th="Product">
                            <div class="row">
                                <div class="col-sm-3 hidden-xs"><img src="{{ $details['image'] }}" width="100"
                                        height="100" class="img-responsive" /></div>
                                <div class="col-sm-9">
                                    <h4 class="nomargin">{{ $details['product_name'] }}</h4>
                                </div>
                            </div>
                        </td>
                        <td data-th="Price">{{ $details['price'] }} Руб</td>
                        <td data-th="Quantity">
                            <input type="number" value="{{ $details['quantity'] }}"
                                class="form-control quantity cart_update" min="1" />
                        </td>
                        <td data-th="Subtotal" class="text-center">{{ $details['price'] * $details['quantity'] }} Руб</td>
                        <td class="actions" data-th="">
                            <button class="btn btn-danger btn-sm cart_remove"><i class="bi bi-trash"></i>Удалить</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right">
                    <h3><strong>Итог: {{ $total }} руб</strong></h3>
                </td>
            </tr>
            <tr>
                <td colspan="5" class="text-right">
                    <a href="{{ url('/') }}" class="btn btn-primary"> <i
                            class="bi bi-arrow-left"></i>Продолжить покупки</a>
                    <button class="btn btn-success"><i class="bi bi-bag"></i> Купить</button>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
@section('scripts')
    <script>
        $(".cart_update").change(function(e) {
            e.preventDefault();
            let ele = $(this);
            $.ajax({
                url: '{{ route('update_cart') }}',
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ele.parents("tr").attr("data-id"),
                    quantity: ele.parents("tr").find(".quantity").val()
                },
                success: function(response) {
                    window.location.reload();
                }
            });
        });

        $(".cart_remove").click(function(e) {
            e.preventDefault();

            let ele = $(this);

            if (confirm("Do you really want to remove?")) {
                $.ajax({
                    url: '{{ route('remove_from_cart') }}',
                    method: "delete",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: ele.parents("tr").attr("data-id")
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
        });
    </script>
@endsection
