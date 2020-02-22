<?php

use App\Comment;
use App\Post;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run()
    {
        Post::all()->each(function (Post $post) {
            $post->comments()->saveMany(
                factory(Comment::class, random_int(1, 10))->make()
            );
        });
    }
}
