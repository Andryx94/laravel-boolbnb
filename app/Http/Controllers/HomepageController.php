<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Apartment;

class HomepageController extends Controller
{
  public function index()
  {
    //variabile con data corrente
    $now = Carbon::now();

    //query di tutti gli appartamenti sponsorizzati
    $apartmentSponsorships= DB::table('apartments')
    ->join('apartment_sponsorship', 'apartments.id', '=', 'apartment_sponsorship.apartment_id')
    ->join('sponsorships', 'apartment_sponsorship.sponsorship_id', '=', 'sponsorships.id')
    ->select('apartments.id','apartments.title','apartments.address','apartments.city','apartments.img_main_path','apartments.visible','apartments.lat','apartments.lng','apartment_sponsorship.created_at', 'sponsorships.duration')
    ->get();

    //ciclo nella variabile della query precedente
    foreach ($apartmentSponsorships as $apartmentSponsorship) {
      //variabile inizio sponsorizzazione
      $sponsorshipDateStart = new Carbon($apartmentSponsorship->created_at);

      //variabile fine sponsorizzazione
      $sponsorshipDateEnd = $sponsorshipDateStart->addHour($apartmentSponsorship->duration);

      //ottengo l'appartamento sponsorizzato e se la data corrente è maggiore di quella della fine della sponsorizzazione, elimino quest'ultima
      $apartment = Apartment::where('id', '=', $apartmentSponsorship->id)->get();
      if ($now->greaterThan($sponsorshipDateEnd)){
        $apartment[0]->sponsorships()->detach();
      };
    }

    return view('homepage', compact('apartmentSponsorships'));
  }

  public function show(Apartment $apartments)
  {
    return view('guest.apartments.show', compact('apartments'));
  }
}
