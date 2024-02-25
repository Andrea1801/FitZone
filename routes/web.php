<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\MemberController;


Route::post('/registerUser',[UserController::class,'registerUser']);
Route::post('/loginUser',[UserController::class,'loginUser']);
Route::post('/logout',[UserController::class,'logout']);
Route::get('/isLogged',[UserController::class,'isLogged']);
Route::get('/getUserData',[UserController::class,'getUserData']);
Route::get('/getUsers',[UserController::class,'getUsers']);
Route::post('/deleteUser/{id}',[UserController::class,'deleteUser']);
Route::post('/adminUser/{id}',[UserController::class,'adminUser']);

Route::post('/addCoach',[CoachController::class,'addCoach']);
Route::get('/getCoaches',[CoachController::class,'getCoaches']);
Route::post('/deleteCoach/{id}',[CoachController::class,'deleteCoach']);
Route::post('/updateCoach/{id}',[CoachController::class,'updateCoach']);

Route::post('/addTraining',[TrainingController::class,'addTraining']);
Route::get('/getTraining',[TrainingController::class,'getTrainings']);
Route::post('/deleteTraining/{id}',[TrainingController::class,'deleteTraining']);

Route::post('/addMember',[MemberController::class,'addMember']);
Route::get('/getMembers',[MemberController::class,'getMember']);
Route::post('/deleteMember/{id}',[MemberController::class,'deleteMember']);


Route::get('/search',[CoachController::class,'searchCoach']);



Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');
