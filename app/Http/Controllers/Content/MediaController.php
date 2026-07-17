<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\MediaType;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

/**
 * @group Post
 * @subgroup Media
 */
class MediaController extends Controller
{
    /**
     * Upload Media
     * 
     * Upload a Media and associate it to the specified Post
     */
    public function store(Request $request, $id){
        $validation = Validator::make($request->all(), [
            'medias' => 'required|array',
            'medias.*' => 'file|mimetypes:image/jpeg,image/png,video/mp4,video/x-msvideo,video/quicktime|max:1000000000',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ], 422);
        }

        $post = Post::where('id', $id)->first();

        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }

        $user = $request->user();
        $asso = $post->organization_id ?? null;

        // Vérifie si l'utilisateur fait partie de l'organisation OU si l'utilisateur est le créateur du post
        if (($asso && $user->isInOrganization($asso)) || (!$asso && $user->id == $post->user_id)) {
            // Logique pour uploader les fichiers
            $tab_media = [];
            foreach($request->medias as $media){
                $type = explode('/', $media->getMimeType())[0];
                $type_id = MediaType::where('type', $type)->first()->id;
                $name = uniqid($post->id . '_' . time() . '_') . '.' . $media->getClientOriginalExtension();
                $stored_path = $media->storeAs('public/medias/'. $type . '/' . $name);
                $stored_media = Media::create([
                    'post_id' => $post->id,
                    'media_type_id' => $type_id,
                    'media_url' => asset('storage/medias/'. $type . '/' . $name),
                ]);
                $tab_media[] = $stored_media;
            }

            return response()->json([
                'message' => 'Files uploaded successfully',
                'medias' => $tab_media
            ], 200);
        } else {
            return response()->json([
                'message' => 'You are not authorized to upload files in this post'
            ], 403);
        }
    }

    /**
     * Delete Media
     * 
     * Remove the specified Media from the Server
     * 
     * @queryParam medias_id int[] required The ID of the media to delete
     */
    public function destroy(Request $request, $id){
        $medias_id = $request->query('medias_id',[]);

        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }

        $user = $request->user();
        $asso = $post->organization_id ?? null;

        $medias_number = Media::whereIn('id', $medias_id)->count();

        // Vérifie si tous les medias on été trouuvés ou non
        if ($medias_number < count($medias_id)) {
            return response()->json([
                'message' => (count($medias_id) - $medias_number) . ' Medias not found'
            ], 404);
        }

        // Vérifie si l'utilisateur fait partie de l'organisation OU si l'utilisateur est le créateur du post
        if (($asso && $user->isInOrganization($asso)) || (!$asso && $user->id == $post->user_id)) {
            foreach ($medias_id as $media_id){
                $media = Media::find($media_id);

                $deleted_medias[] = $media;

                $media->delete();
            }
        } else {
            return response()->json([
                'message' => 'You are not authorized to destroy files in this post'
            ], 403);
        }

        return response()->json([
            'message' => 'Media deleted successfully',
            'medias' => $deleted_medias
        ], 200);
    }
}

