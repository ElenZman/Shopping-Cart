<div class="container my-3" style="height:5em">
    <ul class="nav">
        @auth
            @if (Auth::user()->role == 'admin')
                <li class="nav-item">
                    <a href="{{ route('add_item') }}" class="nav-link">Добавить товар</a>
                </li>
            @endif
        @endauth

        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">Каталог</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Здесь будет еще одна ссылка</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Возможно еще одна</a>
        </li>
    </ul>
</div>

