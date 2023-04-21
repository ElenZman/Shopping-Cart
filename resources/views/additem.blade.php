@extends('layouts.app')
@section('title')
    Новый товар
@endsection
@section('content')
    @guest
        <h1>
            Посторонним вход воспрещен
        </h1>
    @else
        @if (Auth::user()->role == 'admin')
        @if($errors->any())
        @foreach($errors->all() as $error)
        <p>{{$error}}</p>
        @endforeach
        @endif
            <form class="mx-5 row g-3" method="POST" action={{route('create_item')}}>
                @csrf
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="title" class="form-label">Название товара</label>
                        <input type="text" class="form-control" id="" name="title"
                            placeholder="Начните вводить название товара">
                    </div>
                    <div class="col-3">
                        <label for="category" class="form-label">Выберите категорию</label>
                        <select class="form-select" aria-label="Default select example" name="category">
                            <option selected>Выберите категорию</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-2">
                        <label for="price" class="form-label">Цена</label>
                        <input type="number" class="form-control" id="" name="price"/>
                    </div>
                    <div class="col-2">
                        <label for="vendor" class="form-label">Выберите поставщика</label>
                        <select class="form-select" aria-label="Default select example" name="vendor">
                            <option selected>Выберите поставщика</option>
                            @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <label for="description" class="form-label">Описание</label>
                        <textarea class="form-control" rows="3" name="description"></textarea>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <label for="image" class="form-label">Введите ссылку на картинку</label>
                        <input type="text" class="form-control" name="image"></textarea>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <input type="submit" class="btn btn-primary" value="Отправить"/>
                    </div>
                </div>
            </form>
        @else
            <h1>Вы не админ</h1>
        @endif
    @endguest
@endsection
