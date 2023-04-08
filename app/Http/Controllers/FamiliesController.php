<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FamiliesController extends Controller
{
    /**
     * Search Families or Get All Families
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function WhereFamilies(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'words' => 'required|array'
        ]);

        if ($validator->fails()) return response()->json($validator->errors(), 400);

        // TODO: add paginator
        $words = $request->get('words');
        if ($words[0] == '*') {
            $families = Family::all();
        } else {
            $families = Family::where('status', 1)->where(function ($query) use ($request, $words) {
                foreach ($words as $w) {
                    $query->orWhere('word', 'like', '%' . $w . '%');
                }
            })->get();
        }

        return response()->json($families);
    }

    /**
     * Get a Family by id
     *
     * @param $id
     * @return JsonResponse
     */
    public function ShowFamily($id): JsonResponse
    {
        $family = Family::where('id', $id)->firstOrFail();
        return response()->json($family);
    }

    public function NewFamily(Request $request): JsonResponse
    {

    }
}
