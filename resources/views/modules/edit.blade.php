@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Modifier le Module</h1>
        <form action="{{ route('modules.update', $module->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Nom :</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $module->name }}">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description :</label>
                <textarea class="form-control" id="description" name="description">{{ $module->description }}</textarea>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="status" name="status"value="{{ $module->status }}">
                <label class="form-check-label" for="status">Actif</label>
            </div>
            <div class="mb-3">
                <label for="manufacturer" class="form-label">Fabricant :</label>
                <input type="text" class="form-control" id="manufacturer" name="manufacturer" value="{{ $module->manufacturer }}">
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">Modèle :</label>
                <input type="text" class="form-control" id="model" name="model" value="{{ $module->model }}">
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
    </div>
@endsection
