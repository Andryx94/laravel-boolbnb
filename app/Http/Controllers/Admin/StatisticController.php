<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Apartment;
use App\Statistic;

class StatisticController extends Controller
{
  public function index(Apartment $apartments)
  {
    $user = Auth::id();
    //query di tutti gli appartamenti dell'utente loggato
    $apartments = DB::table('apartments')->select('*')->where('user_id', $user)->get();

    return view('admin.statistics.index', compact('apartments'));
  }

  public function show(Statistic $statistics, Apartment $apartment)
  {
    $id_apartment = $apartment->id;
    $number_stat = DB::table('statistics')->select('*')->where('apartment_id', $id_apartment)->count();
    return view('admin.statistics.show', compact('apartment', 'number_stat'));
  }
}
