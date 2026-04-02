<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class DashboardController extends Controller
{

    public function index()
    {
        return view('dashboard.index', [
            'user' => auth()->user(),
            // 'carsCount' => Car::count(),
        ]);
    }

    public function profile()
    {
        return view('dashboard.profile', [
            'user' => auth()->user(),
        ]);
    }

}
