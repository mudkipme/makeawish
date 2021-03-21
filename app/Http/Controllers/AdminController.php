<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    /**
     * Admin page
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function show(Request $request)
    {
        $query = Post::where('public', 1)->where('patrolled', '!=', 1)
            ->where('message', '!=', '')->whereNotNull('message');
        $total = $query->count();
        $page = min(max(1, intval($request->input('page'))), ceil($total / 30));
        $posts = $query->orderBy('created_at', 'DESC')->skip(($page - 1) * 30)->take(30)->get();

        return inertia('admin', [
            'title' => 'Admin Panel',
            'posts' => $posts,
            'page' => $page,
            'total' => $total,
        ]);
    }

    public function approval($postId)
    {
        $post = Post::find($postId);
        if (! $post) {
            abort(404, 'Post not found.');
        }
        $post->patrolled = 1;
        $post->save();
        return response()->json($post);
    }

    public function hide($postId)
    {
        $post = Post::find($postId);
        if (! $post) {
            abort(404, 'Post not found.');
        }
        $post->public = 0;
        $post->save();
        return response()->json($post);
    }
}
