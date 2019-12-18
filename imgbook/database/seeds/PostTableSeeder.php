<?php

use App\Post;
use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $a = new Post;
        $a->title = "This is a test post";
        $a->description = "This description is a test description for the article test post";
        $a->user_id = 1;
        $a->save();

        factory(App\Post::class, 10)->create();
    }
}
