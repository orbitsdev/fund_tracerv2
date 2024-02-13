<?php

namespace Database\Seeders;

use App\Models\MOOEGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MOOEGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $travel = MOOEGroup::create(['title' => 'Travel Expenses']);
        $communication = MOOEGroup::create(['title' => 'Communication Expenses']);
        $supplies_and_materials = MOOEGroup::create(['title' => 'Supplies and Materials Expenses']);
        $training_and_scholarship = MOOEGroup::create(['title' => 'Training and Scholarship Expenses']);
        $proffesional_service = MOOEGroup::create(['title' => 'Proffesional Service']);


        // Define the options for expenses
        $travel_options = [
            [
                'title' => 'Travelling Expenses- Local',
            ],
            [
                'title' => 'Travelling Expenses- Foreign',
            ],
        ];
        $communication_options = [
            [
                'title' => 'Mobile Expenses',
            ],
            [
                'title' => 'Internet Subscription Expenses',
            ],

        ];

        $supplies_and_materials_options = [
            [
                'title' => 'Office Supplies Expenses',
            ],
            [
                'title' => 'Office Supplies and Materials Expenses',
            ],
            [
                'title' => 'Semi-Expendable Furniture, Fixture and Books Expenses',
            ],

        ];
        $training_and_scholarship_options = [
            [
                'title' => 'Training Expenses',
            ],


        ];
        $proffesional_service_options = [
            [
                'title' => 'Legal and Auditing Service',
            ],
            [
                'title' => 'Consultancy Service',
            ],
            [
                'title' => 'Other Proffessional Services',
            ],


        ];


        $travel->m_o_o_e_expenses()->createMany($travel_options);
        $communication->m_o_o_e_expenses()->createMany($communication_options);
        $supplies_and_materials->m_o_o_e_expenses()->createMany($supplies_and_materials_options);
        $training_and_scholarship->m_o_o_e_expenses()->createMany($training_and_scholarship_options);
        $proffesional_service->m_o_o_e_expenses()->createMany($proffesional_service_options);
    }
}
