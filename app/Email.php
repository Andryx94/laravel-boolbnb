<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
  protected $fillable = [
    'apartment_id','sender_email','object',
    'content',
  ];

  public function apartment(){
    return $this->belongsTo('App\Apartment');
  }
}
