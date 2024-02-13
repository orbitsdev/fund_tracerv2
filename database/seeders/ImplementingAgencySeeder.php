<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ImplementingAgency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ImplementingAgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collections = ['Sultan Kudarat State University'];

        foreach($collections  as $data){
            ImplementingAgency::create(['title'=> $data]);
        }
    }
}
