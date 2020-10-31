<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Apartment;
use App\Statistic;

class ApartmentController extends Controller
{
  public function index()
  {
    $apartments = Apartment::all();

    //query di tutti gli appartamenti sponsorizzati
    $apartmentSponsorships= DB::table('apartments')
    ->join('apartment_sponsorship', 'apartments.id', '=', 'apartment_sponsorship.apartment_id')
    ->join('sponsorships', 'apartment_sponsorship.sponsorship_id', '=', 'sponsorships.id')
    ->select('apartments.id','apartments.title','apartments.address','apartments.city','apartments.img_main_path','apartments.visible','apartments.lat','apartments.lng', 'apartment_sponsorship.created_at', 'sponsorships.duration')
    ->get();

    return view('guest.apartments.index', compact('apartments', 'apartmentSponsorships'));
  }

  public function show(Apartment $apartment)
  {
    $user = Auth::id();

    //se l'id dell'utente loggato è uguale a quello del proprietario dell'appartamento mostra la pagina da admin
    if($user === $apartment->user_id) {
      return view('admin.apartments.show', compact('apartment'));
    }
    //altrimenti visualizza la pagina da guest
    else {
      //creazione nuova visita appartamento (tabella statistiche)
      $new_view = new Statistic();
      $new_view->apartment_id = $apartment->id;
      $new_view->created_at = Carbon::now();
      $new_view->save();
      return view('guest.apartments.show', compact('apartment'));
    }
  }
}
