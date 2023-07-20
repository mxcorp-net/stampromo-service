<?php

namespace App\Http\Controllers\Store\Products;

use App\Commons\Enums\EntityStatus;
use App\Commons\Enums\OrderBy;
use App\DTOs\Store\ProductDto;
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class StoreProductsController extends Controller
{

    /**
     * Get Details of a specific Product
     * @param $id
     * @return JsonResponse
     * @throws BadRequestException
     */
    public function ProductDetails($id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:products,id'
        ]);

        if ($validator->fails()) throw new BadRequestException(errors: (array)$validator->errors());

        $product = Product::where('id', $id)->where('status', EntityStatus::Enable)->first();

        return response()->json(new ProductDto($product));
    }

    /**
     * Get all products with filter and pagination
     * @throws BadRequestException
     * @throws ValidationException
     */
    public function GetProducts(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'page' => 'numeric|min:1',
            'page_items' => 'numeric|min:10',
            'order_by' => 'string|min:4',
            'order' => [new Enum(OrderBy::class)],
            'color' => 'numeric|exists:colors,id',
            'search' => 'string|min:4'
        ]);

        if ($validator->fails()) throw new BadRequestException(errors: (array)$validator->errors());

        //TODO: add missing filters
        //TODO: add pagination
        $colorFilter = $validator->validated()['color'] ?? 0;
        $products = DB::select("CALL Store_GetProducts($colorFilter)");

        return response()->json($products);
    }
}
