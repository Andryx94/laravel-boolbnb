@extends('layouts.app')
@section('content')
<div class="fix-nav">
  <div class="container-fluid">
    <div class="row">
      <div class="col-6">
        <h1>I miei appartamenti</h1>

        <ul class="pl-0 list-unstyled">
          <li>
            @foreach ($apartments as $apartment)
              <ul class="pl-0 list-unstyled">
                  <li class="single-item-apartment">
                    <div class="row">
                      <div class="col-6">
                        <a href="{{route('admin.apartments.show', $apartment->id)}}">
                          @if ($apartment->img_main_path !== '/img/imgDefault.jpg')
                            <img class="img-fluid rounded mx-auto d-block" src="{{asset('storage') . '/' . $apartment->img_main_path}}" alt="Img">
                          @else
                            <img class="img-fluid" src="{{asset($apartment->img_main_path)}}" alt="Img">
                          @endif
                        </a>
                      </div>

                      <div class="col-6">
                        <h2><a href="{{route('admin.apartments.show', $apartment->id)}}">{{$apartment->title}}</a></h2>
                        <p>{{$apartment->address}} <span>{{$apartment->city}}</span></p>
                      </div>
                    </div>
                  </li>
              </ul>
            @endforeach
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection
