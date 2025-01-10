<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\DemoController;

use App\edu\Generate;

Route::get('/load/{course}', function (string $course) {
    return DemoController::loadCourse($course);
});

Route::get('/print', function () {
    return DemoController::print();
});

Route::post('/print', function (Request $request) {
    return DemoController::correct($request);
});

Route::get('/', function () {
    return view('index');
});
