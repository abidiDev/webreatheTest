<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use Illuminate\Support\Facades\Route;
use App\Models\Historique;
use Illuminate\Support\Facades\DB;



class ModuleController extends Controller
{
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
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
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      // Validate the request data
      $request->validate([
          'name' => 'required|max:255', // Assuming 'name' is the attribute for the module's name
          'description' => 'nullable', // You can adjust validation rules based on your requirements
          'status' => 'boolean', // Assuming 'status' is a boolean field indicating if the module is active
          'manufacturer' => 'nullable|max:255',
          'model' => 'nullable|max:255',
      ]);
  
      // Create a new module instance with the validated data
      $module = new Module();
      $module->name = $request->name;
      $module->description = $request->description;
      $module->status = $request->has('status'); // Convert checkbox value to boolean
      $module->manufacturer = $request->manufacturer;
      $module->model = $request->model;
      
      // Save the module to the database
      $module->save();
  
      // Redirect to the index page with a success message
      return redirect()->route('modules.index')->with('success', 'Module created successfully.');
  }
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
 // Trouver le module à mettre à jour
 $module = Module::find($id);

 // Vérifier si le module existe
 if (!$module) {
     // Gérer le cas où le module n'existe pas, par exemple, rediriger vers une autre page ou afficher une erreur
     return redirect()->route('modules.index')->with('error', 'Le module que vous essayez de mettre à jour n\'existe pas.');
 }

 // Valider les données de la requête
 $request->validate([
     'name' => 'required|max:255',
     'description' => 'nullable',
     'status' => 'boolean',
     'manufacturer' => 'nullable|max:255',
     'model' => 'nullable|max:255',
 ]);

 // Mettre à jour le module avec les données validées
 $module->name = $request->name;
 $module->description = $request->description;
 $module->status = $request->has('status');
 $module->manufacturer = $request->manufacturer;
 $module->model = $request->model;

 // Enregistrer les modifications dans la base de données
 $module->save();

 // Rediriger vers la liste des modules avec un message de succès
 return redirect()->route('modules.index')->with('success', 'Module mis à jour avec succès.');

  }
  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $Module = Module::find($id);
    $Module->delete();
    return redirect()->route('modules.index')
      ->with('success', 'Module deleted successfully');
  }
  // routes functions
  /**
   * Show the form for creating a new Module.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('modules.create');
  }
  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $Module = Module::find($id);
    return view('modules.show', compact('Module'));
  }
  /**
   * Show the form for editing the specified Module.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
{
    // Récupérer le module correspondant à l'ID
    $module = Module::find($id);

    // Vérifier si le module existe
    if (!$module) {
        // Gérer le cas où le module n'existe pas, par exemple, rediriger vers une autre page ou afficher une erreur
        return redirect()->route('modules.index')->with('error', 'Le module demandé n\'existe pas.');
    }

    // Retourner la vue d'édition avec le module
    return view('modules.edit', compact('module'));
}

public function showHistory(Module $module)
{
    $history = Historique::where('module_id', $module->id)->get();

    // Nombre total de mesures enregistrées sur une période donnée
    $totalMeasurements = $history->count();

    // Évolution des mesures au fil du temps (par jour, par semaine, par mois)
    $measurementsByDay = Historique::where('module_id', $module->id)
        ->select(DB::raw('DATE(mesure_date) as date'), DB::raw('count(*) as count'))
        ->groupBy(DB::raw('DATE(mesure_date)'))
        ->get();

    // Tendance des valeurs mesurées au fil du temps (graphique)
    $measurementsTrend = Historique::where('module_id', $module->id)
        ->select('mesure_date', 'mesure_value')
        ->orderBy('mesure_date')
        ->get();

    // Moyenne, médiane, minimum et maximum des valeurs mesurées
    $averageValue = $history->avg('mesure_value');
    $medianValue = $history->median('mesure_value');
    $minValue = $history->min('mesure_value');
    $maxValue = $history->max('mesure_value');

    // Nombre de mesures par localisation
    $measurementsBylocalisation = Historique::where('module_id', $module->id)
        ->select('localisation', DB::raw('count(*) as count'))
        ->groupBy('localisation')
        ->get();

    // Calcul de l'écart-type
    $mean = $history->avg('mesure_value');
    $squaredDifferences = $history->map(function ($item) use ($mean) {
        return pow($item->mesure_value - $mean, 2);
    });
    $variance = $squaredDifferences->avg();
    $standardDeviation = sqrt($variance);

    // Passer les données récupérées à la vue
    return view('modules.history', [
        'module' => $module,
        'history' => $history,
        'totalMeasurements' => $totalMeasurements,
        'measurementsByDay' => $measurementsByDay,
        'measurementsTrend' => $measurementsTrend,
        'averageValue' => $averageValue,
        'medianValue' => $medianValue,
        'minValue' => $minValue,
        'maxValue' => $maxValue,
        'measurementsBylocalisation' => $measurementsBylocalisation,
        'standardDeviation' => $standardDeviation,
    ]);
}


}
