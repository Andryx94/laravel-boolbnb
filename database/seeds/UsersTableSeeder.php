<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
      //ciclo 5 utenti
      for ($i=0; $i < 5 ; $i++) {
        $new_user = new User();
        $new_user->firstname = $faker->firstName($gender = null);
        $new_user->lastname = $faker->lastName;
        $new_user->birth_date = $faker->date($format = 'Y-m-d', $max = '2002-09-23');
        $new_user->email = $faker->freeEmail;
        $new_user->password = Hash::make('password', ['rounds' => 12,]);
        $new_user->save();
      }
    }
}
