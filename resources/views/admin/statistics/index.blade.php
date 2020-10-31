@extends('layouts.app')
@section('content')
  <div class="fix-nav">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 statistics-list">
          <h1>Statistiche Divise Per Appartamento</h1>

          <div class="row">
            <div class="col-6 statistics-box">
              @foreach ($apartments as $apartment)
                <div>
                  <h2><a href="{{route('admin.statistics.show', $apartment->id)}}">{{$apartment->title}}</a></h2>
                  <p>{{$apartment->address}} <span>{{$apartment->city}}</span></p>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
