@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Titre de la page -->
    <h1 class="mb-4">Historique des mesures du module "{{ $module->name }}"</h1>

    <!-- Statistiques générales -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Statistiques générales
        </div>
        <div class="card-body">
            <p><strong>Nombre total de mesures enregistrées :</strong> {{ $totalMeasurements }}</p>
            <p><strong>Moyenne des valeurs mesurées :</strong> {{ $averageValue }}</p>
            <p><strong>Médiane des valeurs mesurées :</strong> {{ $medianValue }}</p>
            <p><strong>Valeur minimale enregistrée :</strong> {{ $minValue }}</p>
            <p><strong>Valeur maximale enregistrée :</strong> {{ $maxValue }}</p>
        </div>
    </div>

    <!-- Évolution des mesures au fil du temps -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            Évolution des mesures au fil du temps
        </div>
        <div class="card-body">
            <p>Graphique de l'évolution des mesures au fil du temps à ajouter ici</p>
        </div>
    </div>

    <!-- Nombre de mesures par type -->
    <div class="card">
        <div class="card-header bg-info text-white">
            Nombre de mesures par type
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Type de mesure</th>
                        <th>Nombre de mesures</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($measurementsByType as $measurement)
                    <tr>
                        <td>{{ $measurement->mesure_type }}</td>
                        <td>{{ $measurement->count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
