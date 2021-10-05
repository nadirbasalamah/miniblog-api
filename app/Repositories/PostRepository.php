<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository
{

    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getAll()
    {
        return $this->post->get();
    }

    public function getById($id)
    {
        $post = Post::where('id', $id)->firstOrFail();
        return $post;
    }

    public function save($data)
    {
        $post = new $this->post;

        $post->user_id = $data['user_id'];
        $post->title = $data['title'];
        $post->content = $data['content'];

        $post->save();

        return $post->fresh();
    }

    public function update($id, $data)
    {
        $post = $this->getById($id);

        $post->title = $data['title'];
        $post->content = $data['content'];

        $post->save();

        return $post;
    }

    public function delete($id)
    {
        $post = $this->getById($id);

        $post->delete();

        return $id;
    }
}
