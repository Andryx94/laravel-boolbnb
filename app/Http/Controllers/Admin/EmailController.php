<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Apartment;
use App\Email;

class EmailController extends Controller
{
  public function index(Apartment $apartments)
  {
    $user = Auth::id();

    //query di tutti gli appartamenti dell'utente loggato
    $apartments = DB::table('apartments')->select('*')->where('user_id', $user)->get();

    return view('admin.messages.index', compact('apartments'));
  }

  public function show(Email $emails, Apartment $apartment)
  {
    return view('admin.messages.show', compact('apartment'));
  }
}
