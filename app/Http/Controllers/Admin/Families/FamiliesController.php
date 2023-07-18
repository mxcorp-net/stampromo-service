<?php

namespace App\Http\Controllers\Admin\Families;

use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Models\FamilyAttribute;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FamiliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Search Families or Get All Families
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function WhereFamilies(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|string|min:1'
        ]);

        if ($validator->fails()) return response()->json($validator->errors(), 400);

        $words = explode(' ', $request->get('text'));
        if ($words[0] == '*') {
            $families = Family::all();
        } else {
            $families = Family::where('status', 1)->where(function ($query) use ($request, $words) {
                foreach ($words as $w) {
                    $query->orWhere('name', 'like', '%' . $w . '%'); // TODO: improve query
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

    /**
     * Create a New Family
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function NewFamily(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:families,name|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $family = Family::create([
            'name' => $request->get('name'),
            'description' => $request->get('description')
        ]);

        return response()->json($family);
    }

    /**
     * Get all Attributes in the Family
     *
     * @param $id
     * @return JsonResponse
     */
    public function GetFamilyAttributes($id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|numeric|exists:families,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $attributes = FamilyAttribute::select(['id', 'name', 'type'])->where('family_id', $id)->get();

        return response()->json($attributes);
    }

    /**
     * Update Family info
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function UpdateFamily(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:families,id',
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $exist = Family::where('name', $request->get('name'))->where('id', '!=', $request->get('id'))->count();
        if ($exist > 0) {
            return response()->json((object)['error' => "The name already been taken."], 400);
        } else {
            $family = Family::find($request->get('id'));
            $family->name = $request->get('name');
            $family->description = $request->get('description');
            $family->save();

            return response()->json($family);
        }

    }

}
