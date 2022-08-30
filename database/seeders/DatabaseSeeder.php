<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        User::factory()->count(10)->create();

        Role::create([
            'name' => 'Admin',
        ]);

        $permissions = [
            "project responsable",
            "project participante",
            "activity responsable",
            "activity participante",
        ];

        foreach (range(0, count($permissions) - 1) as $iteration) {
            Permission::create([
                'name' => $permissions[$iteration],
            ]);
        }
    }
}
