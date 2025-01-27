<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\DemoController;
use App\Http\Controllers\Demo2Controller;

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


Route::get('V2/load/{exo}', function (string $exo) {
    return Demo2Controller::loadCourse($exo);
});

Route::get('V2/print', function () {
    return Demo2Controller::print();
});

Route::post('V2/print', function (Request $request) {
    return Demo2Controller::correct($request);
});
