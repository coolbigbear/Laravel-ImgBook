<?php

use Illuminate\Database\Seeder;
use App\Image;
use App\Post;

class ImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $post = Post::find(1);
        $i = new Image;
        $i->image = "/storage/images/golden-retriever-puppy.jpg";
        $post->image()->save($i);

        //Clear temp folder!
        $files = glob('/home/vagrant/laravel/laravel-web-app/imgbook/storage/app/public/images/tmp/{,.}*', GLOB_BRACE);
        foreach($files as $file){ // iterate files
            if(is_file($file))
                unlink($file); // delete file
        }

        factory(App\Image::class, 10)->create();

    }
}
