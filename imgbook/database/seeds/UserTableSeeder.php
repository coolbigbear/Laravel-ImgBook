<?php

use App\User;
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
        $a = new User;
        $a->username = "coolbigbear";
        $a->email = "coolbigbear@gmail.com";
        $a->password = bcrypt('password');
        $a->email_verified_at = now();
        $a->type = User::ADMIN_TYPE;
        $a->save();

        factory(App\User::class, 10)->create();
    }
}
