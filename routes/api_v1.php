<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

route::get("/test", function ($request="hello"){
   dd($request);
});
