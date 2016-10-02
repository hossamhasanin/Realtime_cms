<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $user = new User;
        $user->name = "admin";
        $user->email = "admin@admin.com";
        $user->password = bcrypt("admin");

        $user->save();
    }
}
