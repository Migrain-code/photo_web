<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['name' => 'Brand Strategy', 'order' => 1],
            ['name' => 'Visual Identity', 'order' => 2],
            ['name' => 'Packaging & Product', 'order' => 3],
            ['name' => 'Website & Digital', 'order' => 4],
            ['name' => 'Sales-Driven Creative', 'order' => 5],
            ['name' => 'Ongoing Support', 'order' => 6],
        ];

        foreach ($services as $service) {
            \App\Models\Service::create([
                'name' => $service['name'],
                'order' => $service['order'],
                'is_active' => true,
            ]);
        }
    }
}
