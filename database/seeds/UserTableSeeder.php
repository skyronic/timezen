<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = factory(\App\User::class)->make([
            'name' => 'John',
            'email' => 'john@example.org',
            'password' => Hash::make('woodfish')
        ]);

        $team1 = new App\Team([
            'name' => "A-Team",
            'join_token' => "a4c9f3"
        ]);
        $team1->save ();
        $team2 = new App\Team([
            'name' => "B-Team",
            'join_token' => "hello"
        ]);
        $team2->save ();

        $user1->teams()->attach($team1);
        $user1->teams()->attach($team2);

        $team1->users()->saveMany(factory(\App\User::class, 10)->create());
        $team2->users()->saveMany(factory(\App\User::class, 10)->create());

    }
}
