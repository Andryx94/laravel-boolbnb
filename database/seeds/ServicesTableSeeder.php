<?php

use Illuminate\Database\Seeder;
use App\Service;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $arrayServizi = ['wifi','posto macchina','piscina','portineria','sauna','vista mare'];

      //ciclo tutti i servizi
      for ($i=0; $i < count($arrayServizi) ; $i++) {
        $new_service = new Service();
        $new_service->name = $arrayServizi[$i];
        $new_service->save();
      }
    }

}
