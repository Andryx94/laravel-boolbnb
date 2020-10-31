@extends('layouts.app')
@section('content')
  <div class="fix-nav">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 message-list">
          <h1>Emails Ricevute Divise Per Appartamento</h1>

          <div class="row">
            <div class="col-6 single-message">
              @foreach ($apartments as $apartment)
                <div>
                    <h2><a href="{{route('admin.messages.show', $apartment->id)}}">{{$apartment->title}}</a></h2>
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
