<?php

use Designbycode\Datatables\Tests\Stubs\Post;

it('check if post model is working', function () {
    $post = Post::create(['title' => 'first', 'content' => 'content']);
    expect($post->title)->toEqual('first');
});
