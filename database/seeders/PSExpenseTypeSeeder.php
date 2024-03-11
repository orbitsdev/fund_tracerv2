<?php

namespace Database\Seeders;

use App\Models\PSExpenseType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PSExpenseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $type = ['month','meeting','quarter','hour','day','consultation'];
        foreach ($type as $type) {
            PSExpenseType::create([
                'title'=> $type
            ]);
        }
    }
}
