<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Children;
use App\Models\Pregnancy;
use App\Models\PregnancyChildren;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory(20)->create();

        $children = Children::factory(30)
            ->make()
            ->each(function ($child) use ($users) {
                $child->user_id = $users->random()->id;
                $child->save();
            });

        foreach ($users as $user) {
            if (rand(1, 3) > 1) {
                continue;
            }

            Pregnancy::factory(1)
                ->make()
                ->each(function ($preg) use ($user) {
                    $preg->user_id = $user->id;
                    $preg->save();

                    PregnancyChildren::factory(rand(1, 4))
                        ->make()
                        ->each(function ($pc) use ($preg) {
                            $pc->pregnancy_id = $preg->id;
                            $pc->save();
                        });
                });
        }
    }
}
