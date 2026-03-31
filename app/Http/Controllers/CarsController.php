<?php

namespace App\Http\Controllers;

class CarsController extends Controller
{

    public function index()
    {
        return view('cars');
    }

    public function show($id)
    {
        return view('cars', [
            'carId' => $id
        ]);
    }

}
