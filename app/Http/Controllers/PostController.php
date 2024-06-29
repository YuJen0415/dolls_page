<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:1000',
        ]);

        $imagePath = $request->file('image')->store('posts', 'public');

        Auth::user()->posts()->create([
            'image_path' => $imagePath,
            'caption' => $request->caption,
        ]);

        return redirect()->route('home')->with('success', '貼文已成功上傳！');
    }
}