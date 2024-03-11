<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\EOGroupSeeder;
use Database\Seeders\PSGroupSeeder;
use Database\Seeders\MOOEGroupSeeder;
use Database\Seeders\PSExpenseTypeSeeder;
use Database\Seeders\MonitoringAgencySeeder;
use Database\Seeders\ImplementingAgencySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            PSExpenseTypeSeeder::class,
            PSGroupSeeder::class,
            MOOEGroupSeeder::class,
            EOGroupSeeder::class,
            ProgramSeeder::class,
            ImplementingAgencySeeder::class,
            MonitoringAgencySeeder::class,
            YearSeeder::class,

        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
