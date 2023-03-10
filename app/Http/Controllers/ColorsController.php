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

    public function GetColors(Request $request): JsonResponse
    {
        // TODO: implement search by name, hex, status and dates
        return response()->json($request->all());
    }
}
