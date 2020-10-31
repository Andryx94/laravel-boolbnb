<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
  protected $fillable = [
    'user_id','title','description',
    'rooms','beds','baths',
    'square_mt','address','city',
    'lng','lat','img_main_path',
    'visibile',
  ];

  public function services(){
    return $this->belongsToMany('App\Service');
  }

  public function sponsorships(){
    return $this->belongsToMany('App\Sponsorship')->withTimestamps();
  }

  public function images(){
    return $this->hasMany('App\Image');
  }

  public function emails(){
    return $this->hasMany('App\Email');
  }

  public function statistics(){
    return $this->hasMany('App\Statistic');
  }

  public function user(){
    return $this->belongsTo('App\User');
  }
}
