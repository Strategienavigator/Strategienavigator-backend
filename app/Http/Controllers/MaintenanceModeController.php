<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use JetBrains\PhpStorm\NoReturn;

class MaintenanceModeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {

        if(App::isDownForMaintenance()){
            $checked = true;
        }else{
            $checked = false;
        }
        return view('maintenanceMode.index', ['checked' =>$checked]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function toggleMaintenanceMode(Request $request): JsonResponse
    {
        $isActive = $request->input('isActive');

        if ($isActive) {

            Artisan::call('down');
            $message = 'Maintenance mode activated';
        } else {

            Artisan::call('up');
           $message = 'Maintenance mode deactivated';
        }

        return response()->json(['message' => $message]);
    }

}
