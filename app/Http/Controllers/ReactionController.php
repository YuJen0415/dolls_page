<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reaction;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    public function toggle(Request $request, Post $post)
    {
        $request->validate([
            'type' => 'required|in:like,love,haha,wow,sad,angry',
        ]);

        $reaction = $post->reactions()->where('user_id', auth()->id())->first();

        if ($reaction) {
            if ($reaction->type === $request->type) {
                $reaction->delete();
            } else {
                $reaction->update(['type' => $request->type]);
            }
        } else {
            $post->reactions()->create([
                'user_id' => auth()->id(),
                'type' => $request->type,
            ]);
        }

        $reactionCount = $post->reactions()->count();

        return response()->json(['reactionCount' => $reactionCount]);
    }
}