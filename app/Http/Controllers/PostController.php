<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\map;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function getAll()
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->postService->getAll();
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getById($id)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->postService->getById($id);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function save(Request $request)
    {
        $data = $request->only([
            'title',
            'content'
        ]);

        $data['user_id'] = Auth::id();

        $result = ['status' => 200];

        try {
            $result['data'] = $this->postService->save($data);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function update($id, Request $request)
    {
        $data = $request->only([
            'title',
            'content'
        ]);

        $result = ['status' => 200];

        try {
            $result['data'] = $this->postService->update($id, $data);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function delete($id)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->postService->delete($id);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }
}
