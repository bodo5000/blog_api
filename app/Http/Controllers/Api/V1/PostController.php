<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\V1\PostsCollection;
use App\Http\Resources\V1\PostsResource;
use App\Models\Post;

class PostController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $posts = new PostsCollection(Post::all());

        return $this->apiResponse($posts, 'ok', 200);
    }

    public function show($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return $this->apiResponse(null, 'not found', 404);
        }

        return $this->apiResponse(new PostsResource($post), 'ok', 200);
    }

    public function store(PostRequest $request)
    {
        $formData = $request->except('_token');
        $post = Post::create($formData);

        if ($post) {
            return $this->apiResponse(new PostsResource($post), 'post has created', 201);
        }

        return $this->apiResponse(null, 'error while creating post', 400);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);
        $formData = $request->except(['_token', '_method']);

        if (!$post) {
            return $this->apiResponse(null, 'there is no post to update', 400);
        }

        $post->update($formData);
        return $this->apiResponse(new PostsResource($post), 'post has been updated', 200);
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return $this->apiResponse(null, 'there is no post to delete', 400);
        }

        $post->delete();
        return $this->apiResponse(null, 'post has been deleted', 200);
    }
}
