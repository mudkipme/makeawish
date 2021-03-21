<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public function submit(Request $request)
    {
        if (boolval(Config::get('app.campaign_ended'))) {
            abort(403, 'The campaign has ended.');
        }

        $request->validate([
            'name' => ['required', 'unique:posts'],
            'email' => ['required', 'email', 'unique:posts'],
            'upload' => ['nullable', 'max:2048', 'mimes:jpeg,bmp,png,gif,webp'],
        ]);

        $source = Source::where('name', Config::get('app.default_source'))->first();
        if (! $source) {
            $source = Source::create([
                'name' => Config::get('app.default_source'),
                'url' => Config::get('app.url'),
            ]);
        }

        $file = $request->file('upload');
        $postData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
            'public' => $request->input('public') ? 1 : 0,
        ];

        if ($file) {
            $image = Image::make($file->getRealPath());
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads', $filename);
            $postData['upload_filename'] = Storage::url($path);
            $postData['upload_width'] = $image->width();
            $postData['upload_height'] = $image->height();
        }

        DB::transaction(function () use ($postData, $source) {
            $source->posts()->create($postData);
            $source->post_number = $source->post_number + 1;
            $source->save();
        });

        return back();
    }

    public function like($postId)
    {
        $post = Post::find($postId);
        if (! $post) {
            abort(404, 'Post not found.');
        }
        $post->like();
        return response()->json($post);
    }
}
