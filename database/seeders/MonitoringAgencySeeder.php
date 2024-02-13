<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MonitoringAgency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MonitoringAgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $collections = ['DOST-PCAARRD'];

        foreach($collections  as $data){
            MonitoringAgency::create(['title'=> $data]);
        }
    }
}
