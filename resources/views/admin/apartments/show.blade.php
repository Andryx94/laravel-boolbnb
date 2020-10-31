@extends('layouts.app')
@section('content')
  <div class="admin-apartment fix-nav">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="single-apartment">
            <a class="get-back-button" href="{{route('admin.apartments.index', $apartment)}}">Torna indietro</a>
            <div class="intro">
              <h2>{{$apartment->title}}</h2>
              <p>{{$apartment->city}}</p>
            </div>

            <div class="row">
              <div class="col-6 img-box">
                @if ($apartment->img_main_path !== '/img/imgDefault.jpg')
                  <img class="img-fluid" src="{{asset('storage') . '/' . $apartment->img_main_path}}" alt="Img">
                @else
                  <img class="img-fluid" src="{{asset($apartment->img_main_path)}}" alt="Img">
                @endif

                {{-- @foreach ($apartment->images as $image)
                  <img class="img-fluid" src="{{$image->img_path}}" alt="Img">
                @endforeach --}}
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
                <hr>

                <div class="edit-apartment">
                  <a href="{{route('admin.apartments.edit_photo', $apartment)}}" class="btn btn-primary buttons">Modifica Foto</a><br>
                  <a href="{{route('admin.apartments.edit', $apartment)}}" class="btn btn-primary buttons">Modifica appartamento</a>
                </div>

                <div class="delete-apartment">
                  <form class="" action="{{route('admin.apartments.destroy', $apartment)}}" method="post">
                    @csrf
                    @method('DELETE')

                    <input class="btn btn-danger buttons" type="submit" value="Elimina appartamento">
                  </form>
                </div>
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
        </div>
      </div>
      <hr>

      <div class="row">
        <div class="col-6 chart-box">
          <div class="img-fluid">
            <canvas id="laa" width="400" height="400"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
  // Grafico statistiche
  var url = 'http://localhost:8888/laravel-boolbnb/public/';
  var ctx = $('#myChart');

    $.ajax({
      url: url + "api/statistics",
      method: 'GET',
      success: function(views){
        // Array statistiche
        var statistics = views.statistics;
        // Scorro tutti gli array
        var gen = [];
        var feb = [];
        var mar = [];
        var apr = [];
        var mag = [];
        var giu = [];
        var lug = [];
        var ago = [];
        var set = [];
        var ott = [];
        var nov = [];
        var dic = [];
        var months = [
          gen,feb,mar,apr,mag,giu,lug,ago,set,ott,nov,dic
        ];
        for (var i = 0; i < statistics.length; i++) {
          // Id statistica appartamento
          var statisticsApartamentId = statistics[i].apartment_id;

          // mese statistica
          var statisticsMonth = moment(statistics[i].created_at).format('M');
          var singleMonths;
          // Se l'id della statistica è uguale a quello dell'appartamento

          if (statisticsApartamentId=={{$apartment->id}})
           {
            for (var j = 1; j <= months.length; j++) {
              if (statisticsMonth==j) {
                months[j-1].push(1)
              }
            }
          }
        }

        var viewsMonth = [gen.length,feb.length,mar.length,apr.length,mag.length,giu.length,lug.length,ago.length,set.length,ott.length,nov.length,dic.length];
        // Array viste mensili
        var dataViews = viewsMonth;

        // variabile myChart
        var myChart = new Chart (ctx, {
          type: 'bar',
          data: {
            labels: moment.months(),
            datasets: [{
              label: 'Views',
              backgroundColor: 'rgba(225, 60, 60, 0.2)',
              hoverBackgroundColor: 'rgba(225, 60, 60, 0.6)',
              lineTension: 0.2,
              borderCapStyle: 'butt',
              borderDash: [],
              borderDashOffset: 0.0,
              borderJoinStyle: 'miter',
              pointBorderColor: 'rgba(225, 60, 60)',
              pointBackgroundColor: '#fff',
              pointBorderWidth: 1,
              pointHoverRadius: 5,
              pointHoverBackgroundColor: 'rgba(225, 60, 60)',
              pointHoverBorderColor: "rgba(220,220,220,1)",
              pointHoverBorderWidth: 2,
              pointRadius: 1,
              pointHitRadius: 10,
              // Posizionamento array dati
              data: dataViews,

              borderColor: [
                'rgba(225, 60, 60)'
              ],
              borderWidth: 2
            }]
          },
          options: {
            scales: {
                yAxes: [{
                    ticks: {
                        max: Math.max(...dataViews) + 10,
                        beginAtZero: true
                    }
                }]
            },
            animation: {
              duration: 1500

            },
            legend: {
              align: 'end'
            },
            title: {
              display: true,
              text: 'Andamento visualizzazioni',
              fontSize: 22,
              fontColor: 'rgba(225, 60, 60)',
              fontStyle: 'bold'
            }
          }
        });
      }
    })
  </script>
@endsection
