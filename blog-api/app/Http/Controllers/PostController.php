<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    // post controller
	public function index()
	{
		// Return all posts
		$posts = Post::all();
		
		return response()->json([
			'success' => true,
			'data' => $posts,
		], 200);
	}

	public function show($id)
	{
		// Return a single post
		$post = Post::find($id);
		
		if (!$post) {
			return response()->json([
				'success' => false,
				'message' => 'Post not found',
			], 400);
		}
		
		return response()->json([
			'success' => true,
			'data' => $post,
		], 200);
	}

	public function store(Request $request)
	{
		// Validate request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

		// print hello to the console
		print("hello");

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
		
		// Store a new post
		$post = new Post();
		$post->title = $request->title;
		$post->content = $request->content;
		$post->published_at = $request->published_at;
		$post->save();
		
		return response()->json([
			'success' => true,
			'data' => $post,
		], 200);
	}

	public function update(Request $request, $id)
	{
		// Validate request
		$validator = Validator::make($request->all(), [
			'title' => 'required|string',
			'content' => 'required|string',
		]);

		if ($validator->fails()) {
			return response()->json(['error' => $validator->errors()], 400);
		}
		
		// Update a post
		$post = Post::find($id);
		
		if (!$post) {
			return response()->json([
				'success' => false,
				'message' => 'Post not found',
			], 400);
		}
		
		$post->title = $request->title;
		$post->content = $request->content;
		$post->published_at = $request->published_at;
		$post->save();
		
		return response()->json([
			'success' => true,
			'data' => $post,
		], 200);
	}

	public function destroy($id)
	{
		// Delete a post
		$post = Post::find($id);
		
		if (!$post) {
			return response()->json([
				'success' => false,
				'message' => 'Post not found',
			], 400);
		}
		
		$post->delete();
		
		return response()->json([
			'success' => true,
			'message' => 'Post deleted successfully',
		], 200);
	}
}
