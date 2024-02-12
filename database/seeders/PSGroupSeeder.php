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

        // $honaria_options = [
        //     ['title' => 'Command', 'amount' => 19852.00],
        //     ['title' => 'Project Administrative Aide III', 'amount' => 21064.00],
        //     ['title' => 'Project Administrative Aide IV', 'amount' => 22344.00],
        //     ['title' => 'Project Administrative Aide V', 'amount' => 23693.00],
        //     ['title' => 'Project Administrative Aide VI', 'amount' => 25355.00],
        // ];

        // Create the expenses associated with the salary PSGroup
        $salary->p_s_expenses()->createMany($salary_options);

        // Insert the data into the database
        // foreach ($expenses as $expense) {
        //     DB::table('p_s_expenses')->insert($expense);
        // }

    }
}
