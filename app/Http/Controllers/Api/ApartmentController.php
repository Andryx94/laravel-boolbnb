<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Apartment;


class ApartmentController extends Controller
{
  public function index(){

    //query di tutti gli appartamenti e relativi servizi
    $apartments = DB::table('apartments')
      ->select('apartments.id', 'apartments.user_id', 'apartments.title', 'apartments.description', 'apartments.rooms',
       'apartments.beds', 'apartments.baths', 'apartments.square_mt', 'apartments.address', 'apartments.city',
       'apartments.lng', 'apartments.lat', 'apartments.img_main_path',
       'apartments.visible', 'apartments.created_at', 'apartments.updated_at')
      ->selectRaw('GROUP_CONCAT(name) as services')
      ->groupBy('apartments.id')
      ->leftJoin('apartment_service', 'apartments.id', '=', 'apartment_service.apartment_id')
      ->leftJoin('services', 'services.id', '=', 'apartment_service.service_id')
      ->get();

    return response()->json(compact('apartments'));
  }
}
