<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\SchoolDirector;
use App\Models\Staff;
use App\Models\SystemAdmin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         $admin = User::factory()->create([
             'unique_name' => 'admin',
             'email' => 'admin@kidsclub.com',
             'role' => 'system admin',
             'password' => Hash::make('i am admin'),
         ]);

        $mainAdmin = Staff::create([
            'user_id' => $admin->id,
            'profile_pic' => 'profiles/No-profile.png',
            'first_name' => 'Main',
            'middle_name' => 'Admin',
            'last_name' => 'Default',
            'gender' => ' ',
            'dob' => ' ',
            'address' => ' ',
            'phone' => ' ',
            'role' => 'system admin',
            'qualification' => ' ',
            'certificate' => ' ',
            'date_of_hire' => ' ',
            'salary' => 0,
            'status' => 'active',
        ]);

        SystemAdmin::create([
            'staff_id'=>$mainAdmin->id,
        ]);

         $director = User::factory()->create([
             'unique_name' => 'director',
             'email' => 'director@kidsclub.com',
             'role' => 'school director',
             'password' => Hash::make('i am director'),
         ]);

         $mainDirector = Staff::create([
             'user_id' => $director->id,
             'profile_pic' => 'profiles/No-profile.png',
             'first_name' => 'Main',
             'middle_name' => 'Director',
             'last_name' => 'Default',
             'gender' => ' ',
             'dob' => ' ',
             'address' => ' ',
             'phone' => ' ',
             'role' => 'school director',
             'qualification' => ' ',
             'certificate' => ' ',
             'date_of_hire' => ' ',
             'salary' => 0,
             'status' => 'active',
         ]);

         SchoolDirector::create([
             'staff_id'=>$mainDirector->id,
         ]);
    }
}
