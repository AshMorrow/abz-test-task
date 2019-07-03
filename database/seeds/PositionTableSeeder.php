<?php

use App\User;
use Illuminate\Database\Seeder;

class PositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            'Lead designer',
            'Backend developer',
            'Frontend developer'
        ];

        $admin_user = App\User::first()->id;

        foreach ($positions as $postion) {
            if (!App\Position::where('name', $postion)->count()) {
                App\Position::create([
                    'name' => $postion,
                    'admin_created_id' => $admin_user,
                    'admin_updated_id' => $admin_user
                ]);
            }

        }
    }
}
