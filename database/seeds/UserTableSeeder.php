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
        $user1->profile_saved = true;
        $user1->save ();

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

        $team1->addAdmin ($user1);
        $team2->addAdmin ($user1);

        $user1->teams()->attach($team1);
        $user1->teams()->attach($team2);

        $t1coll = factory(\App\User::class, 10)->make();
        $t2coll = factory(\App\User::class, 10)->make();

        $team1->users()->saveMany($t1coll);
        $team2->users()->saveMany($t2coll);

        // star a few from team1
        $user1->starred()->saveMany($t1coll->random(3));
        $user1->starred()->saveMany($t2coll->random(3));

        $user1->custom()->saveMany(factory(\App\CustomTracker::class, 10)->make());

    }
}
