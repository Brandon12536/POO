<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OOPDemoController;

Route::get('/', function () {
    return redirect('/api/documentation');
});
Route::get('/oop-demo', [OOPDemoController::class, 'show']);
Route::get('/oop-demo/constructor', [OOPDemoController::class, 'showConstructor']);
Route::get('/oop-demo/method', [OOPDemoController::class, 'showMethod']);
Route::get('/oop-demo/inheritance', [OOPDemoController::class, 'showInheritance']);
Route::get('/oop-demo/exception', [OOPDemoController::class, 'showException']);
Route::get('/oop-demo/interface', [OOPDemoController::class, 'showInterface']);
Route::get('/oop-demo/abstract', [OOPDemoController::class, 'showAbstract']);
Route::get('/oop-demo/this-parent', [OOPDemoController::class, 'showThisParent']);
