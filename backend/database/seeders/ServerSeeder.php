<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $file = fopen(resource_path('leaseweb.csv'), 'r');
        while(($line = fgetcsv($file)) !== false){

            DB::table('servers')->insert([
                'Model'     => $line[0],
                'RAM'       => $line[1],
                'HDD'       => $line[2],
                'Location'  => $line[3],
                'Price'     => $line[4],
                'created_at'=> null
            ]);
        }
    }
}
