<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EducationalCertificateController;
use App\Http\Controllers\Api\RuecController;
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

Route::get('/certificatesTest',[EducationalCertificateController::class,'index']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/users/auth', AuthController::class);
    Route::get('/users',[UserController::class,'index']);
    Route::get('/educationalCertificates',[EducationalCertificateController::class,'index']);
    Route::post('/educationalCertificate',[EducationalCertificateController::class,'store']);
    Route::put('/educationalCertificate/{id}',[EducationalCertificateController::class,'update']);
    Route::post('/ruec',[RuecController::class,'store']);
    // TODO: move this to usercontroller
    Route::get('/users/{id}', function ($id) {
        return User::findOrFail($id);
    });
});
