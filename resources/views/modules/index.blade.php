@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des Modules</h1>

       <!-- Affichage des statistiques générales -->
<div class="mb-5">
    <div class="row">
        <div class="col">
            <h3 style="color: #1f7a8c; font-family: 'Arial', sans-serif;">Statistiques Générales</h3>
            <ul class="list-unstyled">
                <li style="font-size: 18px;">Nombre total de modules enregistrés : <span style="color: #ff5733;">{{ $totalModules }}</span></li>
                <li style="font-size: 18px;">Nombre de modules actifs : <span style="color: #1abc9c;">{{ $activeModules }} ({{ number_format($activeModulesPercentage, 2) }}%)</span></li>
                <li style="font-size: 18px;">Nombre de modules inactifs : <span style="color: #e74c3c;">{{ $inactiveModules }} ({{ number_format($inactiveModulesPercentage, 2) }}%)</span></li>
            </ul>
        </div>
        <div class="col">
            <h3 style="color: #1f7a8c; font-family: 'Arial', sans-serif;">Nombre de modules par fabricant</h3>
            <ul class="list-unstyled">
                @foreach($modulesByManufacturer as $module)
                    <li style="font-size: 18px; color: #3498db;">{{ $module->manufacturer }} : <span style="color: #ff5733;">{{ $module->total }}</span></li>
                @endforeach
            </ul>
        </div>
        <div class="col">
            <h3 style="color: #1f7a8c; font-family: 'Arial', sans-serif;">Nombre de modules par modèle</h3>
            <ul class="list-unstyled">
                @foreach($modulesByModel as $module)
                    <li style="font-size: 18px; color: #3498db;">{{ $module->model }} : <span style="color: #ff5733;">{{ $module->total }}</span></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>


        <!-- Formulaire d'ajout de module -->
        <div class="mb-3">
            <a href="{{ route('modules.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle-fill"></i></a>
        </div>

        <!-- Tableau des modules -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Description</th>
                    <th scope="col">État de fonctionnement</th>
                    <th scope="col">Fabricant</th>
                    <th scope="col">Modèle</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($modules as $module)
                    <tr>
                        <td>{{ $module->id }}</td>
                        <td>{{ $module->name }}</td>
                        <td>{{ $module->description }}</td>
                        <td>{{ $module->status ? 'Actif' : 'Inactif' }}</td>
                        <td>{{ $module->manufacturer }}</td>
                        <td>{{ $module->model }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('modules.edit', $module->id) }}" class="btn btn-primary">Modifier</a>
                                <form action="{{ route('modules.destroy', $module->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
