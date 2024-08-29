<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SurnameController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\InvitationController;




Route::group(['midllware' => 'api'], function ($router) {
    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class,'refresh']);
        Route::post('reset' , [AuthController::class, 'reset_password']);
        Route::post('forget_password' , [AuthController::class, 'forget_password']);
    });

    Route::post('inv/public' ,[InvitationController::class , 'store_public_by_visitor']);
    /// Auth Routes 
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('profile', [UserController::class , 'profile']); // 
        Route::put('profile',[UserController::class , 'update_profile']);

        // User Routes (Employees)
        
        Route::group(['prefix' => 'users' , 'middleware' => \App\Http\Middleware\HasPermission::class . ':users_managment'] , function ($router){
            Route::get('', [UserController::class ,'index']);           // 
            Route::post('',[UserController::class , 'store']);          // 
            Route::get('{id}' , [UserController::class , 'show']);      //
            Route::delete('' , [UserController::class , 'destroy']);    //
            Route::put('{id}' ,[UserController::class , 'update']);     //
            Route::put('{id}/permissions' , [UserController::class, 'update_permissoins']);
        });

        // Surname Routes 
        Route::group(['prefix' => 'surnames', 'middleware' => \App\Http\Middleware\HasPermission::class . ':dashboard'] , function($router){
            Route::get('' ,[SurnameController::class , 'index']);
            Route::post('' ,[SurnameController::class , 'store']);
            // Route::get('{id}' ,[SurnameController::class , 'show']);
            Route::delete('' ,[SurnameController::class , 'destroy']);
            Route::put('{id}' ,[SurnameController::class , 'update']);
        });

        // Group Routes
        Route::group(['prefix' => 'groups', 'middleware' => \App\Http\Middleware\HasPermission::class . ':dashboard'] , function($router){
            Route::get('' ,[GroupController::class , 'index']);
            Route::post('' ,[GroupController::class , 'store']);
            // Route::get('{id}' ,[GroupController::class , 'show']);
            Route::delete('' ,[GroupController::class , 'destroy']);
            Route::put('{id}' ,[GroupController::class , 'update']);
        });

        // Group Routes
        Route::group(['prefix' => 'invitations', 'middleware' => \App\Http\Middleware\HasPermission::class .':public_invitations'] , function($router){
            Route::get('' ,[InvitationController::class , 'index']);
            Route::get('{id}' ,[InvitationController::class , 'show']);
            Route::delete('' ,[InvitationController::class , 'destroy']);
            Route::put('{id}' ,[InvitationController::class , 'update']);
            Route::post('private' ,[InvitationController::class , 'store_private'])->middleware(\App\Http\Middleware\HasPermission::class . ':send_invitations');
            Route::put('public/{id}' ,[InvitationController::class , 'update_public']);
            Route::post('public' ,[InvitationController::class , 'store_public']);
            Route::put('private/{id}' ,[InvitationController::class , 'update_private']);
            
        });

        // Seat Routes
        Route::group(['prefix' => 'seats'] , function($router){
            Route::get('' ,[SeatController::class , 'index']);
            Route::get('{id}/history' ,[SeatController::class , 'history'])->middleware(\App\Http\Middleware\HasPermission::class . ':show_history');
            Route::post('{id}/assign' ,[SeatController::class , 'assign_seat'])->middleware(\App\Http\Middleware\HasPermission::class . ':assign_seats');
            Route::get('reports' ,[SeatController::class , 'reports']);
            Route::get('{id}', [SeatController::class,'show']);
        });

        

    });



});
