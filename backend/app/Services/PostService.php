<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Collection;

class PostService
{
    public function getAllPosts(): Collection
    {
        return Post::all();
    }

    public function searchPosts(string $query): Collection
    {
        return Post::where('title', 'like', "%{$query}%")
            ->orWhere('body', 'like', "%{$query}%")
            ->get();
    }

    public function syncPosts(): bool
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

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
} 