<?php

use App\Http\Controllers\Api\Hms\CompanyController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;

 Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
     return $request->user();
 });

Route::post('login', [AuthController::class, 'login']);
Route::get('/companies', function(){
    dd(123);
});

JsonApiRoute::server('hms')->prefix('hms')->middleware('jwt')->resources(function ($server) {
    $server->resource('companies', CompanyController::class)
    ->relationships(function ($relations) {
        $relations->hasMany('users');
    });
});
