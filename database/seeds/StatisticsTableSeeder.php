<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Statistic;

class StatisticsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
      //ciclo 45 appartamenti
      for ($i=0; $i < 45 ; $i++) {
        //ciclo 3 statistiche
        for ($j=0; $j < 3 ; $j++) {
          $new_statistic = new Statistic();
          $new_statistic->apartment_id = $i + 1;
          $new_statistic->save();
        }
      }
    }
}
