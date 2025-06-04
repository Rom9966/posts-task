<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Post::all();
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
        
        return Post::where('title', 'like', "%{$query}%")
            ->orWhere('body', 'like', "%{$query}%")
            ->get();
    }

    public function sync()
    {
        try {
            $response = Http::get('https://jsonplaceholder.typicode.com/posts');
            $posts = $response->json();

            foreach ($posts as $post) {
                Post::updateOrCreate(
                    ['external_id' => $post['id']],
                    [
                        'title' => $post['title'],
                        'body' => $post['body'],
                        'user_id' => $post['userId']
                    ]
                );
            }

            return response()->json(['message' => 'Posts synchronized successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to sync posts'], 500);
        }
    }
}
