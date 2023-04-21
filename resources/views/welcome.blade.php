@extends('layouts.app')
@section('content')
   <div class="container d-flex justify-content-between flex-wrap" style="width: 70%">
    @foreach($data as $card)
    <div class="card" style="width: 16rem;">
        <img src="{{$card->image}}" class="image-fluid card-img-top mx-auto my-1" style="width: 13rem; height: 13rem;" alt="item image">
        <div class="card-body m-1 d-flex flex-column justify-content-between">
            <div style="height:2.5rem" class="my-1">
          <h5 class="card-title"><strong>{{$card->title}}</strong></h5>
            </div>
          <p class="fs-6" class="card-text">{{$card->description}}</p>
          <a href="{{route('add_to_cart', $card->id)}}" class="btn btn-primary">В корзину</a>
        </div>
      </div>
      @endforeach
   </div>
  @endsection

