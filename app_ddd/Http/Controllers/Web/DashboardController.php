<?php

namespace App\Http\Controllers\Web;

use App\Application\Car\UseCases\GetCarsCount;

class DashboardController extends Controller
{

    public function api(GetCarsCount $getCarsCount)
    {
        return response()->json([
            'message' => 'Защищенные данные.',
            'user' => auth()->user(),
            'carsCount' => $getCarsCount->execute(),
        ]);
    }

}
