<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
  
   // Récupérer les données pour afficher la liste des modules
   $modules = Module::all();
  
   // Récupérer les statistiques générales
   $totalModules = Module::count();
   $activeModules = Module::where('status', true)->count();
   $inactiveModules = Module::where('status', false)->count();
  
   // Récupérer les statistiques par fabricant et par modèle
   $modulesByManufacturer = Module::select('manufacturer', \DB::raw('count(*) as total'))
                                   ->groupBy('manufacturer')
                                   ->get();
   $modulesByModel = Module::select('model', \DB::raw('count(*) as total'))
                               ->groupBy('model')
                               ->get();
  
   // Passer les données récupérées à la vue
   return view('modules.index', [
       'modules' => $modules,
       'totalModules' => $totalModules,
       'activeModules' => $activeModules,
       'inactiveModules' => $inactiveModules,
       'modulesByManufacturer' => $modulesByManufacturer,
       'modulesByModel' => $modulesByModel,
   ]);
    }
}
