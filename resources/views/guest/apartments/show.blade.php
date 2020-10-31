@extends('layouts.app')
@section('content')
  <div class="guest-apartment fix-nav">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="single-apartment">
            <div class="intro">
              <h2>{{$apartment->title}}</h2>
              <p>{{$apartment->city}}</p>
            </div>

            <div class="row">
              <div class="col-6 img-box">
                @if ($apartment->img_main_path !== '/img/imgDefault.jpg')
                  <img class="img-fluid rounded" src="{{asset('storage') . '/' . $apartment->img_main_path}}" alt="Img">
                @else
                  <img class="img-fluid rounded" src="{{asset($apartment->img_main_path)}}" alt="Img">
                @endif
              </div>

              <div class="col-6">
                <h5>{{$apartment->title}} situato in {{$apartment->address}}</h5>

                <ul class="ap-characteristics">
                  <li>{{$apartment->rooms}} Stanze - </li>
                  <li>{{$apartment->beds}} Letti - </li>
                  <li>{{$apartment->baths}} Bagni - </li>
                  <li>{{$apartment->square_mt}} m2</li>
                </ul>
                <hr>

                <h4>Descrizione</h4>
                <p>{{$apartment->description}}</p>
                <hr>

                <h4>Servizi</h4>
                <ul class="list-services">
                  @foreach ($apartment->services as $service)
                    <li>{{$service->name}}</li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
          <hr>

          <div class="gmaps">
            <h4>Posizione</h4>
            <!--Google maps -->
            <div id="map"></div>
              <script>
                // Inizializzazione e aggiunta mappa
                function initMap() {
                  // variabile località da coordinate
                  var location = {lat: {{$apartment->lat}}, lng: {{$apartment->lng}}};
                  // Mappa centrata sulla località
                  var map = new google.maps.Map(
                      document.getElementById('map'), {zoom: 15, center: location});
                  // Puntatore posizionato al centro della mappa
                  var marker = new google.maps.Marker({position: location, map: map});
                }
              </script>
            <script defer
            src="https://maps.googleapis.com/maps/api/js?key={{config('services.google.key')}}&callback=initMap">
            </script>
          </div>
          <hr>

          <h4>Scrivi al proprietario</h4>
          @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
          @endif
          <form id="info-form" action="{{ route('guest.apartments.store', $apartment) }}" method="post">
            @csrf
            @method('POST')
            @php
              $user = Auth::id();
            @endphp
            <input hidden type="text" name="apartment_id" value="{{ $apartment->id }}">
            <div class="form-group">
              <input type="text"
              class="sender_email form-control"
              name="sender_email"
              value="{{ $user ? DB::table('users')->where('id', $user)->value('email') : old('sender_email') }}"
              placeholder="indirizzo email">
            </div>
            <div class="form-group">
              <input class="object form-control" type="text" name="object" value="{{old('object')}}" placeholder="oggetto">
            </div>
            <div class="form-group">
              <textarea class="content form-control" name="content" rows="8">{{old('content')}}</textarea>
            </div>

            <input type="submit" value="invio">
          </form>
        </div>
      </div>
    </div>
  </div>

{{-- script mostra indirizzo email --}}
<script>

  var valoreInput = $('.sender_email').attr('temp-value', $('.sender_email').val());
  valoreInput.removeAttr('value');
  $('.sender_email').click(function() {
    $('.sender_email').attr({value: $(this).val($(this).attr('temp-value'))});
  });
</script>

{{-- script validazione jquery --}}
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
  $(document).ready(function () {
    $('#info-form').validate({
        rules: {
            sender_email: {
                required: true,
                email: true
            },
            object: {
                required: true,
            },
            content: {
                required: true,
            },
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
