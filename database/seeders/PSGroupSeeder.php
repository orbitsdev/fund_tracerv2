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
        $sksu = PSGroup::create(['title' => 'Indirect Cost (SKSU)']);
        $dost = PSGroup::create(['title' => 'Indirect Cost (DOST)']);

        // Define the options for expenses
        $salary_options = [
            ['title' => 'Project Development Officer III ', 'p_s_expense_type_id'=> 1,'amount' => 54244.00],
            ['title' => 'Project Assistant Aide III', 'p_s_expense_type_id'=> 1,'amount' => 33130.00],

        ];
        $honoraria_options = [
            ['title' => 'Project Leader', 'p_s_expense_type_id'=> 1,'amount' => 8800],
            ['title' => 'Project Staff Support Level 2', 'p_s_expense_type_id'=> 1,'amount' => 7500.00],
        ];
        $sksu_option = [
            ['title' => 'Project Staff Support Level 2','p_s_expense_type_id'=> 3, 'amount' => 1500.00],
            ['title' => 'Project Staff Support Level 1','p_s_expense_type_id'=> 3, 'amount' => 1000.00],
        ];
        $dost_option = [
            ['title' => 'Project Staff Support Level 2', 'p_s_expense_type_id'=> 3, 'amount' => 1500.00],
            ['title' => 'Project Staff Support Level 1', 'p_s_expense_type_id'=> 3, 'amount' => 1000.00],
        ];


        $salary->p_s_expenses()->createMany($salary_options);
        $honoraria->p_s_expenses()->createMany($honoraria_options);
        $sksu->p_s_expenses()->createMany($sksu_option);
        $dost->p_s_expenses()->createMany($dost_option);


    }
}
