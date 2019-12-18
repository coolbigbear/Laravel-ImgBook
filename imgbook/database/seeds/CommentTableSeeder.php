<?php

use App\Comment;
use Illuminate\Database\Seeder;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $a = new Comment;
        $a->text = "Test comment";
        $a->post_id = 1;
        $a->user_id = 1;
        $a->save();

        factory(App\Comment::class, 20)->create();
    }
}
