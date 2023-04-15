<?php

namespace App\Http\Controllers\Families;

use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Models\FamilyAttribute;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FamilyAttributesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Create and assign Attribute to a Family
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function NewAttribute(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'family_id' => 'required|exists:families,id',
            'name' => 'required|string',
            'type' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $family = Family::find($request->get('family_id'));

        $attribute = FamilyAttribute::create([
            'family_id' => $family->id,
            'name' => $request->get('name'),
            'type' => $request->get('type')
        ]);

        return response()->json($attribute);
    }

    public function UpdateAttribute(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:family_attributes,id',
            'family_id' => 'required|exists:families,id',
            'name' => 'required|string',
            'type' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $attribute = FamilyAttribute::find($request->get('id'));
        $attribute->family_id = $request->get('family_id');
        $attribute->name = $request->get('name');
        $attribute->type = $request->get('type');

        $attribute->save();

        return response()->json($attribute);
    }
}
