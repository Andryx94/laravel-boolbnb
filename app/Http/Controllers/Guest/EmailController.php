<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Apartment;
use App\Email;


class EmailController extends Controller
{

  public function create(Apartment $apartment)
  {
    return view('guest.apartments.show', compact('apartment'));
  }

  public function store(Request $request, Apartment $apartment)
  {
    $data = $request->all();

    $validatedData = $request->validate([
      'apartment_id' => 'required|integer|max:255',
      'sender_email' => 'required|max:100',
      'object' => 'required|max:100',
      'content' => 'required|max:500',
    ]);

    $new_email = new Email();
    $new_email->fill($data);
    $new_email->save();

    return redirect()->route('guest.apartments.show', $apartment);
  }
}
