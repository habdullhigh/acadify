<?php

namespace Database\Seeders;

use App\Enums\OfficeEnum;
use App\Models\Office;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (OfficeEnum::cases() as $office) {
            Office::firstOrCreate([
                'name' => $office->value,
            ]);
        }

        $this->command->info('Offices seeded successfully.');
        $this->command->info('You can now assign users to these offices.');
    }
}
