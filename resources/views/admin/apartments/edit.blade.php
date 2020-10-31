@extends('layouts.app')
@section('content')
  <div class="fix-nav">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h1>Modifica il tuo appartamento</h1>

          @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
          @endif

          <form id="edit-form" action="{{route('admin.apartments.update', $apartment)}}" method="post">
            @csrf
            @method('PUT')

              <input hidden type="number" name="user_id" value="{{$user}}">

              <div class="form-group">
                <label>Titolo</label>
                <input class="title form-control" type="text" name="title" value="{{old('title') ?: $apartment->title}}">
              </div>

              <div class="form-group">
                <label>Descrizione</label>
                <textarea class="description form-control" name="description" rows="8" cols="80">{{old('description') ?: $apartment->description}}</textarea>
              </div>

              <div class="form-group">
                <label>Stanze</label>
                <input class="rooms form-control" type="number" name="rooms" value="{{old('rooms') ?: $apartment->rooms}}">
              </div>

              <div class="form-group">
                <label>Posti letto</label>
                <input class="beds form-control" type="number" name="beds" value="{{old('beds') ?: $apartment->beds}}">
              </div>

              <div class="form-group">
                <label>Bagni</label>
                <input class="baths form-control" type="number" name="baths" value="{{old('baths') ?: $apartment->baths}}">
              </div>

              <div class="form-group">
                <label>Metri quadri</label>
                <input class="square_mt form-control" type="number" name="square_mt" value="{{old('square_mt') ?: $apartment->square_mt}}"><span> m2</span>
              </div>

              <div class="form-group">
                <label>Indirizzo</label>
                <input class="address-input coordinate_address form-control" type="text" name="address" value="{{old('address') ?: $apartment->address}}">
                {{-- store coordinate --}}
                <input hidden class="lat" readonly type="number" name="lat" value="{{old('lat') ?: $apartment->lat}}">
                <input hidden class="lng" readonly type="number" name="lng" value="{{old('lng') ?: $apartment->lng}}">
              </div>

              <div class="form-group input-group-text">
                <label>Città</label>
                <input class="coordinate_city form-control" type="text" name="city" value="{{old('city') ?: $apartment->city}}">
              </div>

              {{-- seleziona i servizi aggiuntivi --}}
              <div class="form-check">
                @foreach ($services as $service)
                  <input class="form-check-input" type="checkbox" name="service[]" value="{{$service->id}}" {{($apartment->services->contains($service)) ? 'checked' : ''}}>
                  <label class="form-check-label">{{$service->name}}</label>
                  <br>
                @endforeach
              </div>

              {{-- <div>
                <label for="img">Immagine</label>
                @if ($apartment->img_main_path !== '/img/imgDefault.jpg')
                  <img src="{{asset('storage') . '/' . $apartment->img_main_path}}" alt="Img">
                @else
                  <img src="{{asset($apartment->img_main_path)}}" alt="Img">
                @endif
                <input type="file" name="img_main_path" accept="image/*">
              </div> --}}

              {{-- attiva/disattiva annuncio --}}
              <div class="form-check text-right">
                <input class="form-check-input" type="checkbox" name="visible" value="{{$apartment->visible}}" {{($apartment->visible == true) ? 'checked' : ''}}>
                <label class="form-check-label">Visibile</label>
              </div>

              <input type="submit" value="Modifica" class="button">
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- script validazione jquery --}}
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#edit-form').validate({
          rules: {
              rooms: {
                  required: true,
                  number: true,
                  digits: true,
                  min: 1,
                  max: 50
              },
              beds: {
                  required: true,
                  number: true,
                  digits: true,
                  min: 1,
                  max: 100
              },
              title: {
                required: true,
                minlength: 1,
                maxlength: 50
              },
              description: {
                  required: true,
                  minlength: 10,
                  maxlength: 500
              },
              baths: {
                  required: true,
                  number: true,
                  digits: true,
                  min: 0,
                  max: 10
              },
              square_mt: {
                  required: true,
                  number: true,
                  digits: true,
                  min: 0,
                  max: 3000
              },
              'service[]' : {
                  required: true,

              }
          },
            errorElement: 'span',
            errorPlacement: function (error, element) {
              error.addClass('invalid-feedback');
              element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
              $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
              $(element).removeClass('is-invalid');
            }
      });
    });
  </script>
@endsection
