<?php

use Illuminate\Database\Seeder;
use App\Sponsorship;

class SponsorshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $durationArray = [24, 72, 144];
      $amountArray = [2.99, 7.99, 9.99];

      //ciclo 3 sponsorizzazioni
      for ($i=0; $i < 3 ; $i++) {
        $new_sponsorship = new Sponsorship();
        $new_sponsorship->duration = $durationArray[$i];
        $new_sponsorship->amount = $amountArray[$i];
        $new_sponsorship->save();
      }
    }
}
