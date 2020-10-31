@extends('layouts.app')
@section('content')
  <div class="fix-nav">
    <div class="container-fluid">
      <div class="row">

        <div class="col-12">
          <a class="get-back-button" href="{{route('admin.statistics.index', $apartment)}}">Torna indietro</a>
          <div class="apart-info">
            <h2>{{$apartment->title}}</h2>
            <p>{{$apartment->address}}<br>{{$apartment->city}}</p>

            <h5>N. Visite Totali: {{$number_stat}}</h5>
          </div>
        </div>


        <div class="wrapper-statistics col-lg-12"  style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('img/statistics-img.jpg')}}'); background-size: cover;">
          {{-- style="background-image: url('{{ asset('img/statistics-img.jpg')}}'); background-size: cover;" --}}
          <div class="row flex-lg-row-reverse">

            <div class="col-lg-6 col-md-12">
              <div class="row">
                <div class="col-lg-6 col-md-12 d-none d-lg-block">
                  <img class="img-statistics" id="img-city" src="{{ asset('img/arrow-left.png')}}" alt="img" style="width: 100%;">
                </div>
                <div class="content-statistics col-lg-6 ">
                  <p>Controlla quante Visite hai avuto questo mese, in questo appartamento.</p>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12">
              <canvas id="myViews" class="box-statistics" width="200" height="180"></canvas>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="row">
                  <div class="content-statistics col-lg-6 col-md-12">
                    <p>Controlla il numero delle e-mail ricevute per questo appartamento in questo mese.</p>
                  </div>
                  <div class="col-lg-6 d-none d-lg-block">
                    <img src="{{ asset('img/arrow-right.png')}}" alt="img" style="width: 100%;">
                  </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
              <canvas id="myEmails" class="box-statistics" width="200" height="180"></canvas>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>

  {{-- Script delle Statistiche --}}
  <script>

  var url = 'http://localhost:8888/laravel-boolbnb/public/';
  var ctx = $('#myViews');
  var ctx2 = $('#myEmails');
// Chiamata statistiche Visite
    $.ajax({
      url: url + "api/statistics",
      method: 'GET',
      success: function(data){
        // Array statistiche
        var dataBase = data.statistics;
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
        for (var i = 0; i < dataBase.length; i++) {
          // Id statistica appartamento
          var dataBaseApartamentId = dataBase[i].apartment_id;

          // mese statistica
          var dataBaseMonth = moment(dataBase[i].created_at).format('M');
          // Se l'id della statistica è uguale a quello dell'appartamento

          if (dataBaseApartamentId=={{$apartment->id}})
           {
            for (var j = 1; j <= months.length; j++) {
              if (dataBaseMonth==j) {
                months[j-1].push(1)
              }
            }
          }
        }

        var data = [gen.length,feb.length,mar.length,apr.length,mag.length,giu.length,lug.length,ago.length,set.length,ott.length,nov.length,dic.length];

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
              data: data,
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
                        max: Math.max(...data),
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

    // Chiamata statistiche Emails
    $.ajax({
      url: url + "api/emails",
      method: 'GET',
      success: function(data){
        // Array statistiche
        var dataBase = data.emails;
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
        for (var i = 0; i < dataBase.length; i++) {
          // Id statistica appartamento
          var dataBaseApartamentId = dataBase[i].apartment_id;

          // mese statistica
          var dataBaseMonth = moment(dataBase[i].created_at).format('M');
          // Se l'id della statistica è uguale a quello dell'appartamento

          if (dataBaseApartamentId=={{$apartment->id}})
           {
            for (var j = 1; j <= months.length; j++) {
              if (dataBaseMonth==j) {
                months[j-1].push(1)
              }
            }
          }
        }

        var data = [gen.length,feb.length,mar.length,apr.length,mag.length,giu.length,lug.length,ago.length,set.length,ott.length,nov.length,dic.length];

        // variabile myChart
        var myChart = new Chart (ctx2, {
          type: 'line',
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
              data: data,
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
                        max: Math.max(...data),
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
              text: 'Andamento e-mail ricevute',
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
