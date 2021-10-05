<?php

namespace App\Services;

use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class PostService
{

    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAll()
    {
        return $this->postRepository->getAll();
    }

    public function getById($id)
    {
        return $this->postRepository->getById($id);
    }

    public function save($data)
    {
        $validator = $this->validateRequest($data);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->postRepository->save($data);

        return $result;
    }

    public function update($id, $data)
    {
        $validator = $this->validateRequest($data);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->postRepository->update($id, $data);

        return $result;
    }

    public function delete($id)
    {
        return $this->postRepository->delete($id);
    }

    public function validateRequest($data)
    {
        $validator = Validator::make($data, [
            'title' => 'required',
            'content' => 'required',
        ]);

        return $validator;
    }
}
