@extends('layouts.app')
@section('content')
  <div class="fix-nav">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 edit-photo">
          <a class="get-back-button" href="{{route('admin.apartments.show', $apartment)}}">Torna indietro</a>
          <h1>Modifica La Foto!</h1>

          <form class="" action="{{route('admin.apartments.update_photo', $apartment)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
              <div class="col-6 old-img-box">
                <div class="">
                  <input hidden type="number" name="user_id" value="{{$user}}">
                </div>

                <label for="img">Immagine corrente</label><br>
                @if ($apartment->img_main_path !== '/img/imgDefault.jpg')
                  <img class="img-fluid" src="{{asset('storage') . '/' . $apartment->img_main_path}}" alt="Img">
                @else
                  <img class="img-fluid" src="{{asset($apartment->img_main_path)}}" alt="Img">
                @endif
                <br>
              </div>

              <div class="col-6">
                <label for="img">Immagine nuova:</label><br>
                <input type="file" name="img_main_path" accept="image/*" class="btn">
                <br>
              </div>
            </div>

            <div class="submit-button">
              <input type="submit" value="Sostituisci" class="btn btn-primary">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
