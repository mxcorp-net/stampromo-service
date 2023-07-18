<?php

namespace App\Http\Controllers\Admin\Providers;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProvidersController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function WhereProviders(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'words' => 'required'
        ]);

        if ($validator->fails()) return response()->json($validator->errors(), 400);

        $words = json_decode($request->get('words'));
        if ($words[0] == '*') {
            $products = Provider::all();
        } else {

            // TODO: search all the unique product id from tag

            $products = Provider::where('status', 1)->where(function ($query) use ($request, $words) {
                foreach ($words as $w) {
                    $query->orWhere('name', 'like', '%' . $w . '%')
                        ->orWhere('business_name', 'like', '%' . $w . '%')
                        ->orWhere('rfc', $w);
                }
            })->get();
        }

        return response()->json($products);
    }
}
