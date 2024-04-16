@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tableau de bord des modules</h1>

    <!-- Affichage des statistiques -->
    <div class="row mb-4">
        <!-- Statistiques générales -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Statistiques Générales</h5>
                    <canvas id="generalStatsChart" style="max-height: 200px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Statistiques par fabricant -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Statistiques par Fabricant</h5>
                    <canvas id="manufacturerStatsChart" style="max-height: 200px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Statistiques par modèle -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Statistiques par Modèle</h5>
                    <canvas id="modelStatsChart" style="max-height: 200px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Gestion des modules -->
    <h1>Gestion des Modules</h1>

    <div class="card mb-4">
        

        <div class="card-body">
            <!-- Formulaire d'ajout de module -->
            <div class="mb-3">
                <a href="{{ route('modules.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Ajouter un module
                </a>
            </div>

            <!-- Tableau des modules -->
            <div class="table-responsive">
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
                            <td>
                                @if($module->status)
                                    <span style="color: #1abc9c;">Actif</span>
                                @else
                                    <span style="color: #e74c3c;">Inactif</span>
                                @endif
                            </td>                            <td>{{ $module->manufacturer }}</td>
                            <td>{{ $module->model }}</td>
                            <td>
                                <div class="btn-group">
                                    
                                    <a href="{{ route('modules.edit', $module->id) }}" class="btn btn-primary">
                                        <i class="fas fa-edit"></i> 
                                    </a>
                                    <form action="{{ route('modules.destroy', $module->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash-alt"></i> 
                                        </button>
                                    </form>
                                    <a href="" class="btn btn-info">
        <i class="fas fa-history"></i> 
    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer  de pages -->
    <footer class="footer bg-secondary text-light py-3" style="opacity: 0.9;">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Nom de l'entreprise</h5>
                    <p>123 Rue de l'Entreprise</p>
                    <p>Ville, Pays</p>
                </div>
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <p>Téléphone : +123456789</p>
                    <p>Email : info@example.com</p>
                </div>
                <div class="col-md-4">
                    <p>&copy; {{ date('Y') }} Nom de l'entreprise. Tous droits réservés.</p>
                </div>
            </div>
        </div>
    </footer>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Récupérer les données des statistiques générales
        var totalModules = {{ $totalModules }};
        var activeModules = {{ $activeModules }};
        var inactiveModules = {{ $inactiveModules }};

        // Initialiser le graphique Chart.js pour les statistiques générales
        var generalStatsChart = new Chart(document.getElementById("generalStatsChart"), {
            type: 'pie',
            data: {
                labels: ["Modules actifs", "Modules inactifs"],
                datasets: [{
                    label: "Statistiques générales",
                    backgroundColor: ["#1abc9c", "#e74c3c"],
                    data: [activeModules, inactiveModules],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Statistiques Générales'
                    }
                }
            }
        });

        // Récupérer les données des statistiques par fabricant
        var manufacturers = @json($modulesByManufacturer->pluck('manufacturer'));
        var manufacturersCount = @json($modulesByManufacturer->pluck('total'));

        // Initialiser le graphique Chart.js pour les statistiques par fabricant
        var manufacturerStatsChart = new Chart(document.getElementById("manufacturerStatsChart"), {
            type: 'bar',
            data: {
                labels: manufacturers,
                datasets: [{
                    label: 'Nombre de modules',
                    data: manufacturersCount,
                    backgroundColor: '#3498db'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Nombre de modules par fabricant'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Récupérer les données des statistiques par modèle
        var models = @json($modulesByModel->pluck('model'));
        var modelsCount = @json($modulesByModel->pluck('total'));

        // Initialiser le graphique Chart.js pour les statistiques par modèle
        var modelStatsChart = new Chart(document.getElementById("modelStatsChart"), {
            type: 'bar',
            data: {
                labels: models,
                datasets: [{
                    label: 'Nombre de modules',
                    data: modelsCount,
                    backgroundColor: '#3498db'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Nombre de modules par modèle'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
