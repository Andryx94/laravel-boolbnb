@extends('layouts.app')
@section('content')
  <div class="fix-nav">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h1>Aggiungi Il Tuo Appartamento</h1>

          @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
          @endif

          <form id="create-form" action="{{route('admin.apartments.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <input hidden type="number" name="user_id" value="{{$user}}">

            <div class="form-group">
              <label>Titolo</label>
              <input class="title form-control" type="text" name="title" value="{{old('title')}}">
            </div>

            <div>
              <label for="img">Immagine principale</label>
              <input type="file" name="img_main_path" accept="image/*">
            </div>

            <div class="form-group">
              <label>Descrizione</label>
              <textarea class="description form-control" name="description" rows="8" cols="80">{{old('description')}}</textarea>
            </div>

            <div class="form-group">
              <label>Stanze</label>
              <input class="rooms form-control" type="number" name="rooms" value="{{old('rooms')}}">
            </div>

            <div class="form-group">
              <label>Posti letto</label>
              <input class="beds form-control" type="number" name="beds" value="{{old('beds')}}">
            </div>

            <div class="form-group">
              <label>Bagni</label>
              <input class="baths form-control" type="number" name="baths" value="{{old('baths')}}">
            </div>

            <div class="form-group">
              <label>Metri quadri</label>
              <input class="square_mt form-control" type="number" name="square_mt" value="{{old('square_mt')}}"><span> m2</span>
            </div>

            <div class="form-group">
              <label>Indirizzo</label>
              <input class="address-input coordinate_address" type="text" name="address" value="{{old('address')}}">
              {{-- store coordinate --}}
              <input hidden class="lat" readonly type="number" name="lat" value="{{old('lat')}}">
              <input hidden class="lng" readonly type="number" name="lng" value="{{old('lng')}}">
            </div>

            <div class="form-group">
              <label>Città</label>
              <input class="coordinate_city form-control" type="text" name="city" value="{{old('city')}}">
            </div>

            <div class="form-check">
              @foreach ($services as $service)
                <input class="form-check-input" type="checkbox" name="service[]" value="{{$service->id}}">
                <label class="form-check-label">{{$service->name}}</label>
                <br>
              @endforeach
            </div>

            {{-- <div>
              <label for="img">Immagini aggiuntive</label>
              <input type="file" name="img_path[]" accept="image/*" multiple>
            </div> --}}

            <input type="submit" value="Aggiungi" class="button">
          </form>
        </div>
      </div>
    </div>
  </div>

 {{-- script validazione jquery --}}
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#create-form').validate({
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
