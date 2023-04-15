<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function WhereProducts(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'words' => 'required|array'
        ]);

        if ($validator->fails()) return response()->json($validator->errors(), 400);

        $words = $request->get('words');
        if ($words[0] == '*') {
            $products = Product::all();
        } else {

            // TODO: search all the unique product id from tag

            $products = Product::where('status', 1)->where(function ($query) use ($request, $words) {
                foreach ($words as $w) {
                    $query->orWhere('name', 'like', '%' . $w . '%')->orWhere('description', 'like', '%' . $w . '%');
                }
            })->get();
        }
    }
}
