@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Titre de la page -->
    <h1 class="mb-4">Historique des mesures du module "{{ $module->name }}"</h1>

    <!-- Section des statistiques générales -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-header">
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
        </div>
      
     <div class="col-md-4">
    <div class="card bg-info text-white">
        <div class="card-header">
            Nombre de mesures par localisation
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Région</th>
                        <th>Nombre de mesures</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($measurementsBylocalisation as $localisation)
                        @php
                            $data = json_decode($localisation);
                        @endphp
                        <tr>
                            <td>{{ $data->localisation }}</td>
                            <td>{{ $data->count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>

    </div>

    <!-- Section de l'historique -->
    <div class="card">
        <div class="card-header bg-secondary text-white">
            Historique complet
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date de mesure</th>
                        <th>Valeur mesurée</th>
                        <th>Région</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($history as $measurement)
                    <tr>
                        <td>{{ $measurement->mesure_date }}</td>
                        <td>{{ $measurement->mesure_value }}</td>
                        <td>{{ $measurement->localisation }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
