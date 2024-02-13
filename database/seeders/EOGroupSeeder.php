<?php

namespace Database\Seeders;

use App\Models\EOGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EOGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $eos = [
            'Ten 10(units) of Desktop Computer @ 50,0000.00/unit',
            'One (1) Photocopier with Printer'
        ];
        foreach ($eos as $eo) {
            EOGroup::create(['title' => $eo]);
        }
    }
}
