<?php

namespace Database\Seeders;

use App\Models\Category\Category;
use App\Models\Level\Level;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory(100)->has(Level::factory()->count(3))->create();

    }

    public function runuser()
    {
        $user = User::where('email', 'admin@admin.com')->first();
        if(!$user) {
            $user = User::create([
                'full_name' => 'admin',
                'nick_name' => 'admin',
                'nationallity' => 'Egyptian',
                'gender' => 'Male',
                'date_of_birth' => '1992-01-08',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin@123456'),
                'avatar' => NULL,
                'active' => 1,
            ]);
        }
        $user->assignRole('Administrator');

        //Create 100 Fake users & players
        User::factory(100)->create();
        //or
        factory(App\User::class, 30)->create();
    }
}
