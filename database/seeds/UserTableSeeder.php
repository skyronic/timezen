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
        $user1 = new \App\User([
            'name' => 'John',
            'email' => 'john@example.org',
            'password' => Hash::make('woodfish')
        ]);
        $user1->save();
    }
}
