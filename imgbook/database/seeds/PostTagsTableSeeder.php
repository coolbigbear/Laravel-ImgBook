<?php

use Illuminate\Database\Seeder;

use App\Tag;
use App\Post;

class PostTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::inRandomOrder()->get();
        foreach ($posts as $post) {
            $tags = Tag::inRandomOrder()->limit(3)->get('id');
            $post->tags()->attach($tags);   
        }
    }
}
