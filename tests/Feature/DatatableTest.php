<?php

use Designbycode\Datatables\Tests\Stubs\Post;

it('can visit posts route', function () {
    $posts = $this->get(route('posts.index'))
        ->assertStatus(200);
});

it('cant see title of post', function () {
    $post = Post::factory()->create(['title' => 'Fake Title']);
    expect($post->title)->toEqual('Fake Title');
});

it('can have multiple posts', function () {
    $posts = Post::factory()->count(10)->create();
    expect($posts)->toHaveCount(10);
});
