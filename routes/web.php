<?php
// routes\web.php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ¡Solo dejamos la ruta principal aquí!
