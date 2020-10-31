@extends('layouts.app')
@section('content')
  <div class="fix-nav">
    <div class="creators container-fluid text-center">
      <h2 class="">Made with ♥ by dream team</h2>
      <div class="row">
        <div class="col-lg-3 col-md-6">
          <img src="{{ asset('img/avatar-sara.png')}}" alt="">
          <h4>Sara Lusa</h4>
          <p class="font-italic">La nota positiva</p>
          <a href="https://www.instagram.com/sarahmay_official/"><i class="fab fa-instagram"></i></a>
          <a href="https://www.linkedin.com/in/sara-lusa/"><i class="fab fa-linkedin"></i></a>
          <a href="https://www.youtube.com/channel/UCtStbIylWZZkMVKzUUl7WMQ"><i class="fab fa-youtube"></i></a>
        </div>

        <div class="col-lg-3 col-md-6">
          <img src="{{ asset('img/avatar-andrea.png')}}" alt="">
          <h4>Andrea Maschio</h4>
          <p class="font-italic">Il Jolly</p>
          <a href="https://www.facebook.com/Andryx94/"><i class="fab fa-facebook-f"></i></a>
          <a href="https://www.instagram.com/andryx94/"><i class="fab fa-instagram"></i></a>
          <a href="https://www.linkedin.com/in/maschioandrea/"><i class="fab fa-linkedin"></i></a>
        </div>

        <div class="col-lg-3 col-md-6">
          <img src="{{ asset('img/avatar-valerio.png')}}" alt="">
          <h4>Valerio D'Ambrosio</h4>
          <p class="font-italic">Lo stratega</p>
          <a href="https://www.linkedin.com/in/valerio-d-ambrosio/"><i class="fab fa-linkedin"></i></a>
        </div>

        <div class="col-lg-3 col-md-6">
          <img src="{{ asset('img/avatar-aldo.png')}}" alt="">
          <h4>Aldo Cahuana</h4>
          <p class="font-italic">Il freddo calcolatore</p>
          <a href="https://www.facebook.com/aldovans"><i class="fab fa-facebook-f"></i></a>
          <a href="https://www.linkedin.com/in/aldo-cahuana-756060ba/"><i class="fab fa-linkedin"></i></a>
        </div>
      </div>
    </div>
  </div>
@endsection
