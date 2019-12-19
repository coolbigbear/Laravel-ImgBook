<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $a = new Tag;
        $a->tag = "Technology";
        $a->save();

        $a = new Tag;
        $a->tag = "Landscapes";
        $a->save();

        $a = new Tag;
        $a->tag = "Pets";
        $a->save();

        $a = new Tag;
        $a->tag = "Cars";
        $a->save();

        $a = new Tag;
        $a->tag = "Food";
        $a->save();

        $a = new Tag;
        $a->tag = "Mountains";
        $a->save();
    }
}
