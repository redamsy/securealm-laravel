<?php

namespace App\Http\Controllers\Api;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\EducationalCertificate;
use App\Http\Resources\EducationalCertificateResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EducationalCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $educationalCertificates = EducationalCertificate::all();
        return EducationalCertificateResource::collection($educationalCertificates);
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
                Rule::unique(EducationalCertificate::class),
                //Rule::unique(User::class),
            ],
        ])->validate();
        $adminExists = Admin::where('user_id', Auth::user()->id )->exists();
        if(!$adminExists){
            return response()->json(["errors" => ["Unauthorized" => "You are not an admin"]], 401);
        }
        // $educationalCertificateExists = EducationalCertificate::where('name', $request->input('name') )->exists();
        // if($educationalCertificateExists){
        //     return response()->json(["errors" => ["message" => "EducationalCertificate already exist"]], 409);
        // }
        $educationalCertificateCreate = EducationalCertificate::create([
            "name" => $request->name,
        ]);
        if($educationalCertificateCreate){
            return new EducationalCertificateResource($educationalCertificateCreate);
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
                'exists:App\Models\EducationalCertificate,id',
                // 'exists:educational_certificates,id',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(EducationalCertificate::class)->ignore($id),
                //Rule::unique('educational_certificates')->ignore($id)
            ],
        ])->validate();

        // $exists = EducationalCertificate::where('name', $request->input('name') )
        //     ->where('id','<>', $id )
        //     ->count();
        // if(($exists == 1)){
        //     return response()->json(["errors" => ["message" => "Resource with this name already exist"]], 409);
        //}

        // $educationalCertificateExists = EducationalCertificate::where('id', $id )->exists();
        // if(!$educationalCertificateExists) {
        //     return response()->json(["errors" => ["message" => "Resource does not exist"]], 404);
        // }

        $educationalCertificateUpdate = EducationalCertificate::where('id', $id)
            ->update([
                    'name'=> $request->name,
            ]);

        if($educationalCertificateUpdate){
            return new EducationalCertificateResource(EducationalCertificate::findOrFail($id));
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
        $educationalCertificate = EducationalCertificate::findOrFail($id);
        if(!$educationalCertificate->regularUsers){
            return response()->json(["errors" => ["message" => "Resource is in use by at least a regular User and can't be deleted."]], 409);
        }

        if($educationalCertificate->delete()){
            return response()->json(["message" => ["EducationalCertificate deleted."]], 201);
        }
    }
}
