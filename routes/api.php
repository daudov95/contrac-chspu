<?php

use App\Http\Controllers\Api\Admin\AdminQuestionController;
use App\Http\Controllers\Api\Admin\AdminUsersController;
use App\Http\Controllers\Api\QuestionController;
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

Route::get('/question/{id}', [QuestionController::class, 'question']);
Route::get('/user/{user_id}/question/{id}/table/{table_id}/{token?}', [QuestionController::class, 'userQuestion']);
Route::post('/question/store', [QuestionController::class, 'store']);


Route::get('/documents/user/{user_id}/question/{question_id}/table/{table_id}/{token?}', [QuestionController::class, 'questionDocuments']);
Route::post('/documents/upload', [QuestionController::class, 'documentUpload']);
Route::post('/documents/destroy', [QuestionController::class, 'destoyDocument']);

Route::get('/comments/{id}/{user_id}', [QuestionController::class, 'comments']);


// ADMIN
Route::post('/admin/question/store', [AdminQuestionController::class, 'adminStore']);
Route::post('/admin/documents/destroy', [AdminQuestionController::class, 'destoyDocument']);
Route::post('/admin/comments/store', [AdminQuestionController::class, 'commentStore']);
Route::post('/admin/comment/destroy', [AdminQuestionController::class, 'commentDestroy']);

// USERS
Route::post('/admin/users/add', [AdminUsersController::class, 'addUsers']);