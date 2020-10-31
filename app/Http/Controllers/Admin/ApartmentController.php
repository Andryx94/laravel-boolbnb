<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Apartment;
use App\Email;
use App\Service;
use App\Statistic;
use Carbon\Carbon;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Apartment $apartments)
    {
      $user = Auth::id();

      //query di tutti gli appartamenti dell'utente loggato
      $apartments = DB::table('apartments')->select('*')->where('user_id', $user)->get();

      return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $user = Auth::id();
      $services = Service::all();
      $emails = Email::all();

      return view('admin.apartments.create', compact('user', 'services','emails'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validatedData = $request->validate([
        'user_id' => 'required|integer|max:255',
        'title' => 'required|max:100',
        'description' => 'nullable|max:500',
        'rooms' => 'required|integer|min:1',
        'beds' => 'required|integer',
        'baths' => 'required|integer',
        'square_mt' => 'required|integer',
        'address' => 'required|max:255',
        'city' => 'required|max:100',
        'lng' => 'required',
        'lat' => 'required',
        'service' => 'required',
      ]);

      $data = $request->all();

      $new_apartment = new Apartment();
      $new_apartment->fill($data);

      //se è stata caricata un immagine dell'appartamento
      if (isset($data['img_main_path'])) {
        $path = $request->file('img_main_path')->store('images', 'public');
        $new_apartment->img_main_path = $path;
      }

      $new_apartment->save();

      //se è stato settato almeno un servizio dell'appartamento
      if (isset($data['service'])) {
        $new_apartment->services()->sync($data['service']);
      }

      return redirect()->route('admin.apartments.show', $new_apartment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
      return view('admin.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
      $user = Auth::id();
      $services = Service::all();
      return view('admin.apartments.edit', compact('apartment', 'user', 'services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartment)
    {
      $validatedData = $request->validate([
        'user_id' => 'required|integer|max:255',
        'title' => 'required|max:100',
        'description' => 'nullable|max:500',
        'rooms' => 'required|integer|min:1',
        'beds' => 'required|integer',
        'baths' => 'required|integer',
        'square_mt' => 'required|integer',
        'address' => 'required|max:255',
        'city' => 'required|max:100',
        'lng' => 'required',
        'lat' => 'required',
        'service' => 'required',
      ]);

      $data = $request->all();

      //se è stato settato la visibilità dell'appartamento
      if (isset($data['visible'])){
        $apartment->visible = true;
      }
      else {
        $apartment->visible = false;
      }

      $apartment->update($data);
      $apartment->save();

      //se è stato settato almeno un servizio dell'appartamento
      if (isset($data['service'])) {
        $apartment->services()->detach();
        $apartment->services()->sync($data['service']);
      }
      else {
        $apartment->services()->detach();
      }

      return redirect()->route('admin.apartments.show', $apartment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
      $apartment->services()->detach();
      $apartment->sponsorships()->detach();
      $apartment->delete();

      return redirect()->route('admin.apartments.index');
    }

    //funzione modifica foto appartamenti
    public function editPhoto(Apartment $apartment) {
      $user = Auth::id();

      return view('admin.apartments.edit_photo', compact('apartment', 'user'));
    }

    //funzione aggiornamento foto appartamenti
    public function updatePhoto(Request $request, Apartment $apartment) {

      $data = $request->all();

      //se è settata un immagine dell'appartamento
      if(isset($data['img_main_path'])) {
        $path = $request->file('img_main_path')->store('images', 'public');
        $data['img_main_path'] = $path;
      }
      else {
        $apartment->img_main_path = '/img/imgDefault.jpg';
      }

      $apartment->update($data);
      $apartment->save();

      return redirect()->route('admin.apartments.show', $apartment);
    }
}
