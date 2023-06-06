<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EducationalCertificateController;
use App\Http\Controllers\Api\RuecController;
use App\Http\Controllers\Api\BloodTypeController;
use App\Http\Controllers\Api\GenderController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/sanctum/token', TokenController::class);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/self', AuthController::class);
    Route::post('/isRequestValid',[AuthController::class,'isRequestValid']);
    //
    Route::get('/users',[UserController::class,'index']);
    Route::post('/setUserTypeAndApproval/{id}',[UserController::class,'setUserTypeAndApproval']);
    //
    Route::get('/educationalCertificates',[EducationalCertificateController::class,'index']);
    Route::post('/educationalCertificate',[EducationalCertificateController::class,'store']);
    Route::put('/educationalCertificate/{id}',[EducationalCertificateController::class,'update']);
    Route::delete('/educationalCertificate/{id}',[EducationalCertificateController::class,'destroy']);
    //
    Route::get('/genders',[GenderController::class,'index']);
    Route::post('/educationagenderlCertificate',[GenderController::class,'store']);
    Route::put('/gender/{id}',[GenderController::class,'update']);
    Route::delete('/gender/{id}',[GenderController::class,'destroy']);
    //
    Route::get('/bloodTypes',[BloodTypeController::class,'index']);
    //
    Route::get('/ruecs/{includeUsers}',[RuecController::class,'index']);
    Route::post('/ruec',[RuecController::class,'store']);
    Route::put('/ruec/batch',[RuecController::class,'updateBatch']);
    // TODO: move this to usercontroller
    Route::get('/users/{id}', function ($id) {
        return User::findOrFail($id);
    });
});
