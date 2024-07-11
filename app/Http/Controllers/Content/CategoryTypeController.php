<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryType;
use Illuminate\Http\Request;

class CategoryTypeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) : \Illuminate\Http\JsonResponse {

        $is_shown = $request->query('is_shown');

        if($is_shown != null){
            $category = CategoryType::filter(request(['search']))->where('is_shown', $is_shown)->orderBy('id')->get();
        } else {
            $category = CategoryType::filter(request(['search']))->where('id','!=',1)->orderBy('id')->get();
        }

        if ($category->isEmpty()) {
            return response()->json([
                'message' => 'Pas de catégoriees trouvées.'
            ], 404);
        }

        return response()->json([
            'data' => $category
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'color' => $category->color,
                    ];
                })
        ], 200)->setEncodingOptions(JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }
}
