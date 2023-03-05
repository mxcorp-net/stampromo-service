<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColorsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function GetColors(Request $request): JsonResponse
    {
        return response()->json($request->all());
    }
}
