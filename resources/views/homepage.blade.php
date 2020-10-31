@extends('layouts.app')
@section('content')
  {{-- Funzione Navbar Homepage (quando si esegue lo scroll) --}}
  <script>
$(function(){
$(window).scroll(function(){
            var somma = 20;
            if($(this).scrollTop()>=somma){
              $(".navbar-home").addClass("bg-white");
              $(".navbar-home").removeClass("navbar-dark");
              $(".navbar-home").addClass("navbar-light");

              $(".ms_logo_white").hide();
              $(".ms_logo").show();

              $("#search-bar ").css({
                "position" : "fixed",
                "top": "10px",
              });
            }
            else if ($(this).scrollTop()<somma){
              $(".navbar-home").removeClass("bg-white");
              $(".navbar-home").removeClass("navbar-light");
              $(".navbar-home").addClass("navbar-dark");

              $(".ms_logo_white").show();
              $(".ms_logo").hide();

              $("#search-bar ").css({
                "position" : "fixed",
                "top": "210px",
                "left": "50%",
              });
            }
        });
    });
 </script>

{{---------------------- Jumbotron ----------------------}}
  <div class="homepage" style="background-image: url('{{ asset('img/jumbotron-img.jpg')}}');">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 ms_jumbotron">

          {{-- Searchbar --}}
          <div id="search-bar" class="search">
            <form class="" action="{{ route('guest.apartments.index') }}" method="get">
              @method('GET')
              <div class="search-box">
                <div>
                  <input class="address-input homepage" type="text" name="search" placeholder="Dove vuoi andare?" value="">
                  <input hidden class="lat" readonly type="number" name="lat" value="{{!empty($_GET['lat']) ? $_GET['lat'] : ''}}">
                  <input hidden class="lng" readonly type="number" name="lng" value="{{!empty($_GET['lng']) ? $_GET['lng'] : ''}}">
                </div>
                <div class="">
                  <button value="search"type="submit" class="button">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
          {{-- fine Searchbar --}}

          {{-- CTA --}}
          <div class="ms_cta">
            <h2>Riscopri l'Italia</h2>
            <p>Cambia quadro. Scopri alloggi nelle vicinanze <br> tutti da vivere, per lavoro o svago.</p>
          </div>
          {{-- fine CTA --}}

        </div>
      </div>

    </div>
  </div>
  {{---------------------- fine Jumbotron ----------------------}}

  {{--------------------- Sponsorizzazioni --------------------}}
  @include('partials.sponsorships')
  {{--------------------- fine Sponsorizzazioni --------------------}}


  {{--------------------- Online experience --------------------}}
<div class="container-experience">
  <div class="container-fluid">
    <div class="d-flex justify-content-between">
      <div class="title-experience">
        <h3>Esperienze online</h3>
        Incontra persone di tutto il mondo mentre provi qualcosa di nuovo. Partecipa a sessioni video interattive, <br> in diretta, condotte da host unici, senza muoverti da casa.
      </div>
    </div>
    <div class="row">
        <div class="col-large col-lg-6 col-md-8">
          <div class="wrapper-experience primary" style="background-image: url('{{ asset('img/cina-image.jpg')}}');">
            <div class="caption">
              Prepara i ravioli cinesi a Shanghai
            </div>
          </div>
        </div>
        <div class="col-large col-lg-6 col-md-4">
          <div class="row">
            <div class="col-small col-lg-6 col-md-12">
              <div class="wrapper-experience " style="background-image: url('{{ asset('img/art-street-image.jpg')}}');">
                <div class="caption">
                  Feminismo tra street art e graffiti
                </div>
              </div>
            </div>
            <div class="col-small col-lg-6 col-md-12">
              <div class="wrapper-experience " style="background-image: url('{{ asset('img/newyork-image.jpg')}}');">
                <div class="caption">
                  Dietro le quinte con un mago di New York
                </div>
              </div>
            </div>
            <div class="col-small col-lg-12 d-none d-lg-block ">
              <div class="wrapper-experience " style="background-image: url('{{ asset('img/cocktail-image.png')}}');">
                <div class="caption">
                  A lezione di cocktail e gender
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
  {{--------------------- fine online experience --------------------}}

          {{-- <!-- Footer -->
          @include('partials.footer') --}}
@endsection
