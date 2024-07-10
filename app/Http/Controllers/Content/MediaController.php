<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\MediaType;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function store(Request $request,$id){
        $validation = Validator::make($request->all(), [
            'media' => [
                'required',
                'file',
                'mimetypes:image/jpeg,image/png,video/mp4,video/x-msvideo,video/quicktime',
            ],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ], 422);
        }

        $type = explode('/', $request->media->getMimeType())[0];

        $type_id = MediaType::where('type', $type)->first()->id;

        $post = Post::where('id', $id)->first();

        if($post->organization_id){
            $author_name = $post->organization->user_name;
        }
        else {
            $author_name = $post->user->user_name;
        }

        $media = $request->file('media');

        $name = uniqid($post->id . '_' . time() . '_' . $author_name . '_') . '.' . $media->getClientOriginalExtension();

        $stored_path = $media->storeAs('public/medias/'. $type . '/' . $name);

        Media::create([
            'post_id' => $post->id,
            'media_type_id' =>$type_id,
            'media_url' => asset('storage/medias/'. $type . '/' . $name),
        ]);

        return response()->json([
            'message' => $type . ' uploaded successfully',
        ], 200);
    }
}

