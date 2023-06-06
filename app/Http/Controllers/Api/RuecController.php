<?php

namespace App\Http\Controllers\Api;
use App\Models\Ruec;
use App\Models\User;
use App\Models\Admin;
use App\Models\EducationalCertificate;
use App\Http\Resources\EducationalCertificateResource;
use App\Models\RegularUser;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RuecController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //TODO: use policies here https://laravel.com/docs/10.x/authorization#creating-policies
        if(!($adminExists = Admin::where('user_id', Auth::user()->id )->exists())){
            return response()->json(["errors" => ["Unauthorized" => "You are not an admin"]], 401);
        }
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
            'educationalCertificateId' => 'required|integer',
            // 'genderId' => [
            //     'required',
            //     'integer',
            //     'exists:genders,id',
            //     // 'exists:App\Models\Gender,id'
            // ],

        ])->validate();

        $exists = Ruec::where('educational_certificate_id', $request->educationalCertificateId )
            ->where('regular_user_id', Auth::user()->id )
            ->count();
        if(($exists == 1)){
            return response()->json(["errors" => ["message" => "Ruec already exist"]], 409);

        }
        $educationalCertificateExists = EducationalCertificate::where('id', $request->educationalCertificateId )->exists();
        if(!$educationalCertificateExists) {
            return response()->json(["errors" => ["message" => "EducationalCertificate does not exist"]], 404);
        }
        $regularUserExists = RegularUser::where('user_id', Auth::user()->id )->exists();
        if(!$regularUserExists) {
            return response()->json(["errors" => ["message" => "RegularUser does not exist"]], 404);
        }

        $ruecCreate = Ruec::create([
            "educational_certificate_id" => $request->educationalCertificateId,
            "regular_user_id" => Auth::user()->id,
        ]);
        if($ruecCreate){
            return new UserResource(User::findOrFail(Auth::user()->id));
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $ruec = Ruec::findOrFail($id);

        if($ruec->delete()){
            return response()->json(["message" => "ruec deleted"], 201);
        }
    }

    public function updateBatch(Request $request) {
        $validator = Validator::make($request->all(), [
            'educationalCertificateIds' => [
                'required',
                'exists:App\Models\EducationalCertificate,id'
                // 'exists:genders,id',
            ],

        ])->validate();
        Ruec::where('regular_user_id',Auth::user()->id)->delete();

        foreach ($request->educationalCertificateIds as $educationalCertificateId) {
            $ruecCreate = Ruec::create([
                "regular_user_id" => Auth::user()->id,
                "educational_certificate_id" => $educationalCertificateId,
            ]);
        }
        return new UserResource(User::findOrFail(Auth::user()->id));

    }
}
