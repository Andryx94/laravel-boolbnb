@extends('layouts.app')
@section('content')
  {{------------------- SEARCH-INDEX -------------------}}
    <div class="fix-nav">
      <div class="container-fluid" style="background-image: url({{asset('img/back-mergellina.jpg')}}); background-size: cover;">
        <div class="wrapper-index row">
          <div class="col-8 ms_jumbotron">
            <div class="">
              <form id="index-form" action="{{ route('guest.apartments.index') }}" method="get">
                @method('GET')
                <div class="form-main">

                  <div class="row">
                    <div class="col-8">

                      <div class="form-group">
                        <label>Dove vai?</label>
                        <input class="address-input index" type="text" name="search" value="{{$_GET['search'] ?: ''}}">
                        {{-- coordinates store --}}
                        <input hidden class="lat" type="number" name="lat" value="{{!empty($_GET['lat']) ? $_GET['lat'] : ''}}">
                        <input hidden class="lng" type="number" name="lng" value="{{!empty($_GET['lng']) ? $_GET['lng'] : ''}}">
                      </div> <br>

                      <div class="form-group">
                        <label>Stanze</label>
                        <input placeholder="Stanze" class="rooms form-control" type="number" name="rooms" value="{{!empty($_GET['rooms']) ? $_GET['rooms']: ''}}">
                      </div> <br>

                      <div class="form-group">
                        <label>Letti</label>
                        <input placeholder="Letti" class="beds form-control" type="number" name="beds" value="{{!empty($_GET['beds']) ? $_GET['beds'] : ''}}">
                      </div> <br>

                      <div class="form-group">
                        <label>Raggio (km)</label>
                        <input placeholder="Raggio (km)" class="radius form-control" type="number" name="radius" value="{{!empty($_GET['radius']) ? $_GET['radius'] : '20'}}">
                      </div>

                    </div>

                      <button value="search"type="submit" class="button">
                        <i class="fas fa-search"></i>
                      </button>

                    <div class="col">
                      <div class="form-services text-right">
                        @php
                        $services = DB::table('services')->select('*')->get();
                        @endphp
                        @foreach ($services as $service)
                          <div class="form-check-inline">
                            <label class="form-check-label">{{$service->name}}</label>
                            <input class="form-check-input service-name" type="checkbox" name="service[]" data-service-name="{{$service->name}}">
                            <br>
                          </div>
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-------------------- FINE SEARCH-INDEX -------------------}}

    {{--------------------- SPONSORSHIPS --------------------}}
    @include('partials.sponsorships')
    {{--------------------- FINE SPONSORSHIPS --------------------}}

    {{-------------------- INDEX-APARTAMENTS -------------------}}
    <div class="container-fluid">
      <div class="row d-flex flex-row-reverse">
        <div class="col-lg-5 col-md-12">
          <div class="row">
            {{-- Mappa citta --}}
            <div class="wrapper-maps col-lg-12">
              <div class="gmaps">
                <!--Google maps -->
                <div id="map"></div>
              </div>
            </div>
            {{-- Fine mappa citta --}}

            {{-- Immagine citta --}}
            <div class="col-lg-12 d-none d-lg-block">
              <div class="img-city" style="height: 480px;">
                <img id="img-city" src="{{ asset('img/city/city-1.png')}}" alt="img" style="width: 100%;">
                {{-- Efetto Immagine --}}
                  <script type = "text/javascript">
                    var image = document.getElementById("img-city");
                    var currentPos = 0;
                    var images = ["{{ asset('img/city/city-1.png')}}",
                    "{{ asset('img/city/city-2.png')}}",
                    "{{ asset('img/city/city-3.png')}}",
                    "{{ asset('img/city/city-4.png')}}",
                    "{{ asset('img/city/city-5.png')}}",
                    "{{ asset('img/city/city-6.png')}}",
                    "{{ asset('img/city/city-7.png')}}",
                    "{{ asset('img/city/city-8.png')}}"]

                    function changeImage() {
                        if (++currentPos >= images.length)
                            currentPos = 0;

                        image.src = images[currentPos];
                      }

                    setInterval(changeImage, 3000);
                    {{-- Fine Efetto Immagine --}}
                </script>
              </div>
            </div>
            {{-- Fine Immagine citta --}}
          </div>
        </div>

        {{-- LISTA APPARTAMENTI --}}
        <div class="col-lg-7 col-md-12">
          <div class="row">
            <div class="apartments-list"></div>
          </div>
        </div>
        {{-- FINE LISTA APPARTAMENTI --}}
      </div>
    </div>
    {{-------------------- FINE INDEX-APARTAMENTS -------------------}}

{{-- scripts --}}
<script type="text/javascript">
// Inizializzazione e aggiunta mappa
function initMap() {
  var locations = [
    ['Bondi Beach', -33.890542, 151.274856, 4],
    ['Coogee Beach', -33.923036, 151.259052, 5],
    ['Cronulla Beach', -34.028249, 151.157507, 3],
    ['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
    ['Maroubra Beach', -33.950198, 151.259302, 1]
  ];
  // variabile località da coordinate
  var location = {lat: {{!empty($_GET['lat']) ? $_GET['lat'] : ''}}, lng: {{!empty($_GET['lng']) ? $_GET['lng'] : ''}}};
  // Mappa centrata sulla località
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 12, center: location});
  // Puntatore posizionato al centro della mappa
  // var marker = new google.maps.Marker({position: location, map: map});
  var marker, i;
  @php
    foreach ($apartments as $apartment) {
      @endphp
      marker = new google.maps.Marker({
        position: new google.maps.LatLng({{$apartment->lat}}, {{$apartment->lng}}),
        map: map
      });
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
      return function() {
        infowindow.setContent(locations[i][0]);
        infowindow.open(map, marker);
      }
    })(marker, i));

    @php }
  @endphp

}
</script>
<script defer
src="https://maps.googleapis.com/maps/api/js?key={{config('services.google.key')}}&callback=initMap">
</script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
  $(document).ready(function () {
    $('#index-form').validate({
        rules: {
            rooms: {
                required: false,
                number: true,
                digits: true,
                min: 1,
                max: 50
            },
            beds: {
                required: false,
                number: true,
                digits: true,
                min: 1,
                max: 100
            },
            radius: {
                required: false,
                number: true,
                digits: true,
                min: 0,
                max: 1000000
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
<script id="handlebars" type="text/x-handlebars-template">

  {{--------------------- NON ALTERARE IL DOM DA QUI  ---------------------}}
  <div class="apartment" data-services="@{{services}}">
    <div class="info-apartment">
      <h5><a href="@{{id}}">@{{title}}</a></h5>
      <p>Indirizzo: @{{address}} <span>@{{city}}</span></p>
    </div>
    <img alt="Img" src="@{{img_main_path}}">
    <span>Distanza: @{{distance}} km</span>
  </div>
  {{----------------------------- FINO A QUI  -----------------------------}}

</script>
@endsection
