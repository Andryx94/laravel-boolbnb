<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Apartment;
use App\Service;

class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
      $services = Service::pluck('id');

      //array città con relative coordinate
      $cityArray = [
        [
          'city' => 'Torino, Piemonte, Italia',
          'lng' => 7.6824892,
          'lat' => 45.0677551
        ],
        [
          'city' => 'Moncalieri, Piemonte, Italia',
          'lng' => 7.68475,
          'lat' => 45.0005
        ],
        [
          'city' => 'Milano, Lombardia, Italia',
          'lng' => 9.1904,
          'lat' => 45.4667
        ],
        [
          'city' => 'Roma, Lazio, Italia',
          'lng' => 12.4853,
          'lat' => 41.8948
        ],
        [
          'city' => 'Firenze, Toscana, Italia',
          'lng' => 11.2556,
          'lat' => 43.7699
        ],
        [
          'city' => 'Napoli, Campania, Italia',
          'lng' => 14.2488,
          'lat' => 40.8359
        ],
        [
          'city' => 'Torre del Greco, Campania, Italia',
          'lng' => 14.3683,
          'lat' => 40.7879
        ],
        [
          'city' => 'Pozzuoli, Campania, Italia',
          'lng' => 14.1219,
          'lat' => 40.8226
        ],
        [
          'city' => 'Caserta, Campania, Italia',
          'lng' => 14.3347,
          'lat' => 41.0821
        ],
        [
          'city' => 'Aosta, Valle d\'Aosta/Vallée d\'Aoste, Italia',
          'lng' => 7.31966,
          'lat' => 45.7371
        ]
      ];

      //ciclo 5 utenti
      for ($i=0; $i < 5 ; $i++) {
        //ciclo 10 appartamenti
        for ($j=0; $j < 10 ; $j++) {
          $new_apartment = new Apartment();
          $new_apartment->user_id = $i + 1;
          $new_apartment->title = $faker->randomElement($array = array ('Ottimo','Stupendo','Bel','Lussuoso','Accogliente','Rinnovato')) . ' ' . $faker->randomElement($array = array ('attico','appartamento','locale')) . ' ' .  $faker->randomElement($array = array('in centro','in campagna','in periferia'));
          $new_apartment->description = $faker-> text($maxNbChars = 200);
          $new_apartment->rooms = rand(2,6);
          $new_apartment->beds = rand(1,6);
          $new_apartment->baths = rand(1,2);
          $new_apartment->square_mt = rand(60,120);
          $new_apartment->address = $faker->randomElement($array = array ('Via','Corso','Strada','Piazza','Viale')) . ' ' . $faker->randomElement($array = array ('Nazionale','Garibaldi','Mazzini','Venezia','Alfieri','Italia')) . ' ' . rand(1,150);
          $new_apartment->city = $cityArray[$j]['city'];
          $new_apartment->lng = $cityArray[$j]['lng'];
          $new_apartment->lat = $cityArray[$j]['lat'];
          $new_apartment->save();

          for ($l=0; $l < 2; $l++) {
            $new_apartment->services()->attach( $services[ rand(0, 5) ] ); //DA RIVEDERE, CREA DOPPIONI
          }
        }
      }
    }
}
