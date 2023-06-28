<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\MovieController;
use App\Http\Controllers\API\ShowController;
use App\Http\Controllers\API\TheaterController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\FuncCall;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// -------- users's endpoints ---------
Route:: get('/users', function(){
    return UserController::getAllUsers();
})->middleware(['auth:api', 'can:users.viewAny']);

Route::get('/users/{id}', function(Request $req){
    return UserController::getUserById($req->id);
})->middleware(['auth:api', 'can:users.view,id']) ;

Route::post('/users', function(Request $req){
    return UserController::createUser($req);
})->middleware(['auth:api', 'can:users.create']);

Route::middleware('auth:api')->patch('/users/{id}', function(Request $req){
    return UserController::updateUser($req, $req->id);
})->middleware(['auth:api', 'can:users.update,id']);

Route::middleware('auth:api')->delete('/users/{id}', function($id){
    return UserController::deleteUseById($id);
})->middleware(['auth:api', 'can:users.delete,id']);
// ------------------------------------

// -------- movies's endpoints ---------
Route::get('/movies', function(){
    return MovieController::getAllMovies();
});
Route::get('/movies/{id}', function(Request $req){
    return MovieController::getMovieById($req->id);
});
Route::post('/movies', function(Request $req){
    return MovieController::createMovie($req);
})->middleware(['auth:api', 'can:movies.create']);

Route::patch('/movies/{id}', function(Request $req){
    return MovieController::updateMovie($req, $req->id);
})->middleware(['auth:api', 'can:movies.update']);

Route::delete('/movies/{id}', function(Request $req){
    return MovieController::deleteMovieById($req->id);
})->middleware(['auth:api', 'can:movies.delete']);
// --------------------------------------

// -------- shows's endpoints -----------
Route::get('/shows', function(){
    return ShowController::getAllShows();
});
Route::get('/shows/details', function(){
    return ShowController::getAllShowsWithFullDetails();
});
Route::get('/shows/{id}', function(Request $req){
    return ShowController::getShowById($req->id);
});

Route::post('/shows', function(Request $req){
    return ShowController::createShow($req);
})->middleware(['auth:api', 'can:shows.create']);

Route::patch('/shows/{id}', function(Request $req){
    return ShowController::updateShow($req, $req->id);
})->middleware(['auth:api', 'can:shows.update']);

Route::delete('/shows/{id}', function(Request $req){
    return ShowController::deleteShowById($req->id);
})->middleware(['auth:api', 'can:shows.delete']);

// --------------------------------------

// -------- theater's endpoints ---------
Route::get('/theaters', function(){
    return TheaterController::getAllTheaters();
});
Route::get('/theaters/{id}', function(Request $req){
    return TheaterController::getTheaterById($req->id);
});

Route::post('/theaters', function(Request $req){
    return TheaterController::createTheater($req);
})->middleware(['auth:api', 'can:theaters.create']);

Route::patch('/theaters/{id}', function(Request $req){
    return TheaterController::updateTheater($req, $req->id);
})->middleware(['auth:api', 'can:theaters.update']);

Route::delete('/theaters/{id}', function(Request $req){
    return TheaterController::deleteTheaterById($req->id);
})->middleware(['auth:api', 'can:theaters.delete']);
// --------------------------------------

// -------- bookings's endpoints ---------
Route::get('/bookings', function(){
    return BookingController::getAllBookings();
})->middleware(['auth:api', 'can:bookings.viewAny']);

Route::get('/bookings/user/{user_id}', function(Request $req){
    return BookingController::getAllBookingsOfUser($req->user_id);
})->middleware(['auth:api', 'can:bookings.viewAllOf,user_id']);

Route::get('/bookings/{id}', function(Request $req){
    return BookingController::getBookingById($req->id);
})->middleware(['auth:api', 'can:bookings.view,id']);

Route::post('/bookings', function(Request $req){
    return BookingController::createBooking($req);
})->middleware(['auth:api']);

Route::delete('/bookings', function(Request $req){
    return BookingController::deleteBookingById($req->id);
})->middleware(['auth:api', 'can:bookings.delete']);
// --------------------------------------

// -------- authenticated's endpoints ---------
Route::post('/auth/login', function(Request $req){
    return AuthController::login($req);
});
Route::post('/auth/register', function(Request $req){
    return AuthController::register($req);
});
Route::delete('/auth/logout', function(Request $req){
    return AuthController::logout($req);
})->middleware(['auth:api']);
// --------------------------------------
