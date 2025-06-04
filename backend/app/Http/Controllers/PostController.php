<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    use ApiResponse;

    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $posts = $this->postService->getAllPosts($perPage);
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $perPage = $request->input('per_page', 10);
        $posts = $this->postService->searchPosts($query, $perPage);
        return PostResource::collection($posts);
    }

    public function sync()
    {
        $success = $this->postService->syncPosts();
        
        if ($success) {
            return $this->successResponse(null, 'Posts synchronized successfully');
        }
        
        return $this->errorResponse('Failed to sync posts', 500);
    }
}
