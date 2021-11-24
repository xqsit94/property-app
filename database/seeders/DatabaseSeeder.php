<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Phone;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)
            ->has(
                Phone::factory()
                    ->count(3)
                    ->state(
                        new Sequence(
                            ["type" => Phone::PHONE_TYPE["MOBILE"]],
                            ["type" => Phone::PHONE_TYPE["WORK"]],
                            ["type" => Phone::PHONE_TYPE["HOME"]]
                        )
                    )
            )
            ->create();
    }
}
