<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Email;

class EmailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
      //ciclo 30 appartamenti
      for ($i=0; $i < 30 ; $i++) {
        //ciclo 3 email
        for ($j=0; $j < 3 ; $j++) {
          $new_email = new Email();
          $new_email->apartment_id = $i + 1;
          $new_email->sender_email = $faker->freeEmail;
          $new_email->object = $faker->words($nb = rand(1,5), $asText = true);
          $new_email->content = $faker-> text($maxNbChars = 50);
          $new_email->save();
        }
      }
    }
}
