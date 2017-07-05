<?php

use App\User;
use App\Profile;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        Profile::truncate();
        
        $user = App\User::create([
            'name' => 'Adam Huang',
            'email' => 'ahuang@bacera.com',
            'password' => bcrypt('test0000'),
            'active' => 1,
        ]);

        $profile = App\Profile::create([
            'user_id' => $user->id,
            'country' => 'Taiwan',
            'designation' => 'Web developer',
            'options' => ['sidebar' => true]
        ]);
    }
}
