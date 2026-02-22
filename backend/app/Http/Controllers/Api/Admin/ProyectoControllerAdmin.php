<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProyectoControllerAdmin extends Controller
{
    //
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Proyecto::all()
        ]);
    }
}
