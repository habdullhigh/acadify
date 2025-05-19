<?php

namespace Database\Seeders;

use App\Enums\OfficeEnum;
use App\Models\Office;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::create([
            'name' => 'TEST student 1',
            'email' => 'user123355@example.com',
            'password' => Hash::make('password'),
            'matric_no' => '2104071221',
        ]);

        $office = Office::where('name', OfficeEnum::DSA->value)->first();
        $this->command->info('Office ID: ' . $office);

        // $user2 = User::create([
        //     'name' => 'TEST Admin 1',
        //     'email' => 'user1234@example.com',
        //     'password' => Hash::make('password'),
        //     'office_id' =>$office->id,
        //     'user_type' => 'admin',
        // ]);

        // $this->command->info('USERS seeded successfully. ' + $user1->name + ' and ');
    }
}
