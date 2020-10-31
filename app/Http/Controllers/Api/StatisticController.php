<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Statistic;

class StatisticController extends Controller
{
  public function index(){
    $statistics = Statistic::all();
    return response()->json(compact('statistics'));
  }
}
