<?php

use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get("stripe", [StripeController::class, "index"])->name("stripe.index");
Route::post("stripe", [StripeController::class, "store"])->name("stripe.payment");
