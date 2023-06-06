<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use App\Http\Resources\GenderResource;
use Illuminate\Http\Request;

class GenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $genders = Gender::all();
        return GenderResource::collection($genders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Gender::class),
                //Rule::unique(User::class),
            ],
        ])->validate();
        $adminExists = Admin::where('user_id', Auth::user()->id )->exists();
        if(!$adminExists){
            return response()->json(["errors" => ["Unauthorized" => "You are not an admin"]], 401);
        }
        // $genderExists = Gender::where('name', $request->input('name') )->exists();
        // if($genderExists){
        //     return response()->json(["errors" => ["message" => "Gender already exist"]], 409);
        // }
        $genderCreate = Gender::create([
            "name" => $request->name,
        ]);
        if($genderCreate){
            return new GenderResource($genderCreate);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $adminExists = Admin::where('user_id', Auth::user()->id )->exists();
        if(!$adminExists){
            return response()->json(["errors" => ["Unauthorized" => "You are not an admin"]], 401);
        }
        //use spread to add additional variable
        $validator = Validator::make(['id' => $id, ...$request->all()], [
            'id' => [
                'required',
                'integer',
                'exists:App\Models\Gender,id',
                // 'exists:educational_certificates,id',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Gender::class)->ignore($id),
                //Rule::unique('educational_certificates')->ignore($id)
            ],
        ])->validate();

        $genderUpdate = Gender::where('id', $id)
            ->update([
                    'name'=> $request->name,
            ]);

        if($genderUpdate){
            return new GenderResource(Gender::findOrFail($id));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $adminExists = Admin::where('user_id', Auth::user()->id )->exists();
        if(!$adminExists){
            return response()->json(["errors" => ["Unauthorized" => "You are not an admin."]], 401);
        }
        $gender = Gender::findOrFail($id);
        if(!$gender->users){
            return response()->json(["errors" => ["message" => "Resource is in use by at least a User and can't be deleted."]], 409);
        }

        if($gender->delete()){
            return response()->json(["message" => ["Gender deleted."]], 201);
        }
    }
}
