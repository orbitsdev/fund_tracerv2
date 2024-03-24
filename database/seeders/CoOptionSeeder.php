<?php

namespace Database\Seeders;

use App\Models\CoOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $capital_outlay = [
            "Purchase of Raw Materials",
            "Acquisition of Office Supplies",
            "Procurement of Laboratory Equipment",
            "Renovation of Warehouse for Storage",
            "Acquisition of Manufacturing Machinery",
            "Supply of Construction Materials",
            "Purchase of Computer Hardware",
            "Obtaining Tools and Equipment",
            "Investment in Production Supplies",
            "Procurement of Maintenance Materials"
        ];

        foreach( $capital_outlay as $value) {
                CoOption::create(['title'=> $value]);
        }
    }
}
