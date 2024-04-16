@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Créer un Module</h1>
           <!-- Votre tableau d'affichage des modules ici -->
          
         <div class="mb-3">
                <a href="{{ route('modules.index') }}" class="btn btn-secondary">Retour à la liste</a>
            </div>
        <form action="{{ route('modules.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nom :</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description :</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="status" name="status" value="1">
                <label class="form-check-label" for="status">Actif</label>
            </div>
            <div class="mb-3">
                <label for="manufacturer" class="form-label">Fabricant :</label>
                <input type="text" class="form-control" id="manufacturer" name="manufacturer">
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">Modèle :</label>
                <input type="text" class="form-control" id="model" name="model">
            </div>
            <button type="submit" class="btn btn-primary">Créer</button>
        </form>
    </div>
@endsection
