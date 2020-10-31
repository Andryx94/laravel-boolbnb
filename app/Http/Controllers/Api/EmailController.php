<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Email;

class EmailController extends Controller
{
  public function index(){
    $emails = Email::all();
    return response()->json(compact('emails'));
  }
}
