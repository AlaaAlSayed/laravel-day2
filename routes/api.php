<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController ;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/posts', [PostController::class, 'index'])->name('api.posts.index')->middleware('auth:sanctum');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('api.posts.show')->middleware('auth:sanctum');
Route::post('/posts',[PostController::class, 'store'])->name('api.posts.store')->middleware('auth:sanctum');


// generated token : 2|65ivBAKkfayDzzroCrze5kzH4WSPmHkcHPqtS24a
// sent in header of ->middleware('auth:sanctum'); routes as :
// Authentication : Bearer 2|65ivBAKkfayDzzroCrze5kzH4WSPmHkcHPqtS24a

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
});


