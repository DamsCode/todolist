<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 9)->create();
        factory(App\Projet::class, 9)->create();
        factory(App\Lists::class, 9)->create();
        factory(App\Task::class, 9)->create();
    }
}
