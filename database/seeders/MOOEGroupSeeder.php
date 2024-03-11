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
        $travel = MOOEGroup::create(['title' => 'Travel Expenses', 'has_option'=>true]);
        $communication = MOOEGroup::create(['title' => 'Communication Expenses', 'has_option'=>true]);
        $supplies_and_materials = MOOEGroup::create(['title' => 'Supplies and Materials Expenses', 'has_option'=>true]);
        $training_and_scholarship = MOOEGroup::create(['title' => 'Training and Scholarship Expenses', 'has_option'=>true]);
        $proffesional_service = MOOEGroup::create(['title' => 'Proffesional Services', 'has_option'=>true]);
        $repair_and_maintenance = MOOEGroup::create(['title' => 'Repaire and Maintenance Expenses', 'has_option'=>true]);
        $other_mooe = MOOEGroup::create(['title' => 'Other MOOE', 'has_option'=>true]);
        $indirect_cost_sksu = MOOEGroup::create(['title' => 'Indirect Cost (SKSU)', 'has_option'=>false]);
        $indirect_cost_dost = MOOEGroup::create(['title' => 'Indirect Cost (DOST XIII)', 'has_option'=>false]);


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
                'title' => 'Other Office Supplies and Materials Expenses',
            ],
            [
                'title' => 'Semi-Expendable Furniture, Fixture and Books Expenses',
                'has_sub_options'=>true,
            ]

        ];
        $training_and_scholarship_options = [
            [
                'title' => 'Training and Expenses',
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
        $repair_and_maintenance_options = [
            [
                'title' => 'Repaire and Maintenance',
            ],
        ];
        $other_mooe_options= [
            [
                'title' => 'Printing and Publication Expense',
            ],
            [
                'title' => 'Presentation Expense',
            ],
        ];
        $indirect_cost_sksu_option= [
            [
                'title' => 'Utilities Expenses',
            ],
            [
                'title' => 'Supplies and Materials',
            ],
        ];
        $indirect_cost_sksu_dost= [
            [
                'title' => 'Travel Expense',
            ],
            [
                'title' => 'Supplies and Materials Expenses',
            ],
            [
                'title' => 'Communication Expenses',
            ],
            [
                'title' => 'Reprenstaion Expenses',
            ],
        ];


        $travel->m_o_o_e_expenses()->createMany($travel_options);
        $communication->m_o_o_e_expenses()->createMany($communication_options);
        $supplies_and_materials->m_o_o_e_expenses()->createMany($supplies_and_materials_options);
        $training_and_scholarship->m_o_o_e_expenses()->createMany($training_and_scholarship_options);
        $proffesional_service->m_o_o_e_expenses()->createMany($proffesional_service_options);
        $repair_and_maintenance->m_o_o_e_expenses()->createMany($repair_and_maintenance_options);
        $other_mooe->m_o_o_e_expenses()->createMany($other_mooe_options);
        $indirect_cost_sksu->m_o_o_e_expenses()->createMany($indirect_cost_sksu_option);
        $indirect_cost_dost->m_o_o_e_expenses()->createMany($indirect_cost_sksu_dost);
    }
}
