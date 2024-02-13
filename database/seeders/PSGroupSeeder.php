<?php

namespace Database\Seeders;

use App\Models\PSGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PSGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $salary = PSGroup::create(['title' => 'Salary']);
        $honoraria = PSGroup::create(['title' => 'Honoraria']);

        // Define the options for expenses
        $salary_options = [
            ['title' => 'Project Administrative Aide II', 'amount' => 19852.00],
            ['title' => 'Project Administrative Aide III', 'amount' => 21064.00],
            ['title' => 'Project Administrative Aide IV', 'amount' => 22344.00],
            ['title' => 'Project Administrative Aide V', 'amount' => 23693.00],
            ['title' => 'Project Administrative Aide VI', 'amount' => 25355.00],
        ];
        $honoraria_options = [
            ['title' => 'One(1) Project Learder @ P8000.00/mo x 12', 'amount' => 105600],
            ['title' => 'One(1) Project Staff Support Level 3 @ 7500', 'amount' => 90000.00],
            ['title' => 'One(1) Project Staff Support Level 3 @ 7500', 'amount' => 90000.00],

        ];


        $salary->p_s_expenses()->createMany($salary_options);
        $honoraria->p_s_expenses()->createMany($honoraria_options);


    }
}
