<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rulePost);
        if ($validator->fails()) {
            return response()->json(["error" => $validator->errors()], 400);
        }

        $title = filter_var($request->title, FILTER_SANITIZE_SPECIAL_CHARS);
        $content = filter_var($request->content, FILTER_SANITIZE_SPECIAL_CHARS);

        $post = new Post();

        $post->title = $title;
        $post->content = $content;
        $post->user_id = $request->user()->id;

        try {
            $post->save();
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

        return response()->json(["status" => "Success"], 200);
    }

    public function getPost(Request $request)
    {
        $user = $request->user();
        $id = $user->id;

        $posts = Post::where("user_id", $id)->get();

        return response()->json($posts, 200);
    }

    public function deletePost(Request $request, $id)
    {
        $postID = ["id" => $id];
        $validator = Validator::make($postID, $this->ruleNumeric);
        if ($validator->fails()) {
            return response()->json(["error" => $validator->errors()], 400);
        }

        Post::destroy($id);

        return response()->json(["status" => "Deleted"], 200);
    }

    public function updatePost(Request $request, $id)
    {
        $postID = ["id" => $id];
        $validatorID = Validator::make($postID, $this->ruleNumeric);
        // $validatorBody = Validator::make($request->all(), $this->rulePost);

        if ($validatorID->fails()) {
            return response()->json(["error" => $validatorID->errors()], 400);
        }
        // if ($validatorBody->fails()) {
        //     return response()->json(["error" => $validatorBody->errors()], 400);
        // }

        $title = filter_var($request->title, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_ENCODE_HIGH);
        $content = filter_var($request->content, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_ENCODE_HIGH);

        Post::where("id", $id)->update(["title" => $title, "content" => $content]);

        return response()->json(["status" => "Updated"], 200);
    }
}
