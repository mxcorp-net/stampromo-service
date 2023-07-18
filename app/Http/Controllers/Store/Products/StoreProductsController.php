<?php

namespace App\Http\Controllers\Store\Products;

use App\Commons\Enums\OrderBy;
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
     * @throws BadRequestException
     * @throws ValidationException
     */
    public function GetProducts(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'page' => 'numeric|min:1',
            'order_by' => 'string|min:4',
            'order' => [new Enum(OrderBy::class)],
            'color' => 'numeric|exists:colors,id',
            'search' => 'string|min:4'
        ]);

        if ($validator->fails()) throw new BadRequestException(errors: (array)$validator->errors());

        $products = DB::select(DB::raw("CALL Store_GetProducts(:color)"), [
            ':color' => $validator->validated()['color'] ?? 0,
        ]);

        return response()->json($products);
    }
}
