<?php

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
        $postions = [
            'Lead designer',
            'Backend developer',
            'Frontend developer'
        ];

        foreach ($postions as $postion) {
            if (!App\Position::where('name', $postion)->count()) {
                App\Position::create(['name' => $postion]);
            }

        }
    }
}
