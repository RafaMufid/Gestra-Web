<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommunityPost;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class CommunityPostController extends Controller
{
    public function index(Request $request)
    {
        $query = CommunityPost::with('comments');

        if ($request->has('topic') && $request->topic != '') {
            $query->where('topic', $request->topic);
        }

        $posts = $query->latest()->take(4)->get();

        $topicCounts = CommunityPost::select('topic', \DB::raw('count(*) as total'))
            ->groupBy('topic')
            ->pluck('total', 'topic');

        return view('community', compact('posts', 'topicCounts'));
    }

    public function allPosts(Request $request)
    {
        $query = CommunityPost::with('comments');

        if ($request->has('topic') && $request->topic != '') {
            $query->where('topic', $request->topic);
        }

        $posts = $query->latest()->get();

        return view('community_full', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'topic' => 'required|string',
        ]);

        $user = session('user');

        CommunityPost::create([
            'title' => $request->title,
            'author' => $user['username'],
            'content' => $request->input('content'),
            'topic' => $request->topic,
            'likes' => 0,
        ]);

        return response()->json(['success' => true]);
    }

    public function like($id)
    {
        if (!session()->has('user')) {
            return response()->json(['success' => false], 401);
        }

        $username = session('user')['username'];
        $post = CommunityPost::findOrFail($id);

        $alreadyLiked = \DB::table('post_likes')
            ->where('community_post_id', $id)
            ->where('username', $username)
            ->first();

        if ($alreadyLiked) {
            \DB::table('post_likes')
                ->where('id', $alreadyLiked->id)->delete();
            $post->decrement('likes');
            $status = 'unliked';
        } else {
            \DB::table('post_likes')->insert([
                'community_post_id' => $id,
                'username' => $username,
                'created_at' => now()
            ]);
            $post->increment('likes');
            $status = 'liked';
        }

        $post->refresh();
        return response()->json(['success' => true, 'likes' => $post->likes, 'status' => $status]);
    }

    public function comment(Request $request, $id)
    {
        if (!session()->has('user')) {
            return redirect()->route('login');
        }

        $request->validate([
            'comment_content' => 'required'
        ]);

        $user = session('user');

        Comment::create([
            'community_post_id' => $id,
            'author' => $user['username'],
            'content' => $request->comment_content
        ]);

        return back();
    }
}
