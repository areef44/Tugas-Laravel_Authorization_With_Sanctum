<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\CategoriesController;
use App\Models\Authors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//route for table books
Route::get("/books", [BooksController::class, "index"])->middleware("auth:sanctum"); // get all data books

Route::get("/books/{id}", [BooksController::class, "show"])->middleware("auth:sanctum"); // get data books by id books

Route::post("/books", [BooksController::class, "store"])->middleware("auth:sanctum"); // store data to database

Route::post("/books/{id}/update", [BooksController::class, "update"])->middleware("auth:sanctum"); // update data by id books

Route::get("/books/{id}/destroy", [BooksController::class, "destroy"])->middleware("auth:sanctum"); //delete data from database



//route for table author
Route::get("/author", [AuthorsController::class, "index"])->middleware("auth:sanctum"); //get all data author

Route::get("/author/{id}", [AuthorsController::class, "show"])->middleware("auth:sanctum"); //get data by id category

Route::post("/author/{id}/update", [AuthorsController::class, "update"])->middleware("auth:sanctum"); // get data by id authors

Route::post("/author", [AuthorsController::class, "store"])->middleware("auth:sanctum"); //store data to database

Route::get("/author/{id}/delete", [AuthorsController::class, "delete"])->middleware("auth:sanctum"); //delete data from database


//route for table categories
Route::get("/category", [CategoriesController::class, "index"])->middleware("auth:sanctum"); //get all data category

Route::get("/category/{id}", [CategoriesController::class, "show"])->middleware("auth:sanctum"); //get data by id category

Route::post("/category/{id}/update", [CategoriesController::class, "update"])->middleware("auth:sanctum"); //get data by id category

Route::post("/category", [CategoriesController::class, "store"])->middleware("auth:sanctum"); //store data to database

Route::get("/category/{id}/destroy", [CategoriesController::class, "destroy"])->middleware("auth:sanctum"); //delete data from database


Route::post("/login", [AuthController::class, 'login']);

Route::get("/me", [AuthController::class, 'getUser'])
    ->middleware("auth:sanctum");
