<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColorsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function ShowColor($id): JsonResponse
    {
        $color = Color::where('id', $id)->firstOrFail();
        return response()->json($color);
    }

    /**
     * Create a new color
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function NewColor(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:colors,name',
            'hex' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $color = Color::create([
            'name' => $request->get('name'),
            'hex' => $request->get('hex')
        ]);

        return response()->json([
            'message' => 'Color successfully registered.',
            'color' => $color
        ]);
    }

    /**
     * Update specific color
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function UpdateColor(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:colors,id',
            'name' => 'required|string|unique:colors,name',
            'hex' => 'required|string',
            'status' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $color = Color::find($request->get('id'));
        $color->name = $request->get('name');
        $color->hex = $request->get('hex');
        $color->status = $request->get('status');
        $color->save();

        return response()->json([
            'message' => 'Color successfully updated',
            'color' => $color
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function WhereColors(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'words' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // TODO: add paginator
        $words = $request->get('words');
        if ($words[0] == '*') {
            $colors = Color::all();
        } else {
            $colors = Color::where('status', 1)->where(function ($query) use ($request, $words) {
                foreach ($words as $w) {
                    $query->orWhere('name', 'like', '%' . $w . '%');
                }

                // TODO: improve filtersx
            })->get();
        }


        return response()->json($colors);
    }
}
