<?php

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
        //
        factory(\App\User::class)->create([
            'name' => 'huy nguyen',
            'email' => 'huy@gmail.com'
        ]);
        factory(\App\User::class, 5)->create();
    }
}
