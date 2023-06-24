<?php

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
Route::get('/users', function(){
    return UserController::getAllUsers();
});
Route::get('/users/{id}', function($id){
    return UserController::getUserById($id);
});
Route::post('/users', function(Request $req){
    return UserController::createUser($req);
});
Route::patch('/users/{id}', function(Request $req){
    return UserController::updateUser($req, $req->id);
});
Route::delete('/users/{id}', function($id){
    return UserController::deleteUseById($id);
});
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
});
Route::patch('/movies/{id}', function(Request $req){
    return MovieController::updateMovie($req, $req->id);
});
Route::delete('/movies/{id}', function(Request $req){
    return MovieController::deleteMovieById($req->id);
});
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
});
Route::patch('/shows/{id}', function(Request $req){
    return ShowController::updateShow($req, $req->id);
});
Route::delete('/shows/{id}', function(Request $req){
    return ShowController::deleteShowById($req->id);
});

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
});
Route::patch('/theaters/{id}', function(Request $req){
    return TheaterController::updateTheater($req, $req->id);
});
Route::delete('/theaters/{id}', function(Request $req){
    return TheaterController::deleteTheaterById($req->id);
});
// --------------------------------------

// -------- bookings's endpoints ---------
Route::get('/bookings', function(){
    return BookingController::getAllBookings();
});
Route::get('/bookings/user/{user_id}', function(Request $req){
    return BookingController::getAllBookingsOfUser($req->user_id);
});
Route::get('/bookings/{id}', function(Request $req){
    return BookingController::getBookingById($req->id);
});
Route::post('/bookings', function(Request $req){
    return BookingController::createBooking($req);
});
Route::delete('/bookings', function(Request $req){
    return BookingController::deleteBookingById($req->id);
});
// --------------------------------------
