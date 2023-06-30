<?php

namespace App\Http\Controllers\Products;

use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Bring a specific product
     * @param int $id
     * @return JsonResponse
     * @throws BadRequestException
     */
    protected function ShowProduct(int $id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:products,id'
        ]);

        if ($validator->fails()) throw new BadRequestException($validator->errors());

        $product = Product::find($id);
        return response()->json($product);
    }

    /**
     * Register a new Product
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function NewProduct(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'provider_id' => 'required|exists:providers,id',
            'family_id' => 'required|exists:families,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product = Product::create($validator->validated());

        return response()->json($product);
    }

    /**
     * Bring the Products list
     * @param Request $request
     * @return JsonResponse
     */
    public function WhereProducts(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|string|min:1'
        ]);

        if ($validator->fails()) return response()->json($validator->errors(), 400);

        $words = explode(' ', $request->get('text'));
        if ($words[0] == '*') {
            $products = Product::where('status', 1)->orderByDesc('created_at')->get();
        } else {

            // TODO: search all the unique product id from tag

            $products = Product::where('status', 1)->where(function ($query) use ($request, $words) {
                foreach ($words as $w) {
                    $query->orWhere('name', 'like', '%' . $w . '%')->orWhere('description', 'like', '%' . $w . '%');
                }
            })->orderByDesc('created_at')->get();
        }

        return response()->json($products);
    }
}
