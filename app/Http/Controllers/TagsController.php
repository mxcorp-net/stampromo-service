<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Get a tag by id
     *
     * @param $id
     * @return JsonResponse
     */
    public function ShowTag($id): JsonResponse
    {
        $tag = Tag::where('id', $id)->firstOrFail();
        return response()->json($tag);
    }

    /**
     * Update specific tag
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function UpdateTag(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:tags,id',
            'word' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $tag = Tag::find($request->get('id'));
        $tag->word = $request->get('word');
        $tag->save();

        return response()->json([
            'message' => 'Tag successfully updated',
            'tag' => $tag
        ]);
    }

    /**
     * Search all tag match
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function GetTags(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'words' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $tags = Tag::where('status', 1)->where(function ($query) use ($request) {
            // 'word', $request->get('words')
            foreach ($request->get('words') as $w) {
                $query->orWhere('word', 'like', '%' . $w . '%');
            }
        })->get();

        return response()->json($tags);
    }

    /**
     * Create a new tag
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function NewTag(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'word' => 'required|unique:tags,word|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $tag = Tag::create([
            'word' => $request->get('word')
        ]);

        return response()->json([
            'message' => 'Tag successfully registered',
            'tag' => $tag
        ]);

    }

    /**
     * Delete a specific tag by id
     *
     * @param $id
     * @return JsonResponse
     */
    public function DeleteTag($id): JsonResponse
    {
        $tag = Tag::where('id', $id)->firstOrFail();
        $tag->delete();

        return response()->json([
            'message' => 'Tag successfully deleted.'
        ]);

    }
}
