<?php

namespace App\Http\Controllers;

abstract class Controller
{
public function index()
{
    return response()->json([
        "status" => "online",
        "version" => "1.0.0",
        "environment" => "docker"
    ], 200);
}    //
}
