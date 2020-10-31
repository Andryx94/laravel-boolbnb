{{-- SPONSORSHIPS --}}
<div id="sponsorships" class="container-fluid">
  <div class="box-apartment-sponsorship row">
    @php
      foreach ($apartmentSponsorships as $apartmentSponsorship) {
        if ($apartmentSponsorship->visible === 1) {
        @endphp
          <div class="col-lg-3 col-sm-6">
            <div class="apartment-sponsorship" data-lat="{{$apartmentSponsorship->lat}}" data-lng="{{$apartmentSponsorship->lng}}">
              <img class="logo-sponsorship" src="{{ asset('img/sponsorship-logo.png')}}" alt="img">
              <div class="info-sponsorship">
              <h3><a href="http://localhost:8888/laravel-boolbnb/public/apartments/{{$apartmentSponsorship->id}}">{{$apartmentSponsorship->title}}</a></h3>

              <p>{{$apartmentSponsorship->address}} <span>{{$apartmentSponsorship->city}}</span></p>
              </div>

              <div class="box-img"><img alt="Img" src="http://localhost:8888/laravel-boolbnb/public/storage/{{$apartmentSponsorship->img_main_path}}"></div>
            </div>
          </div>
        @php }
    } @endphp
  </div>
</div>
{{-- FINE SPONSORSHIPS --}}
