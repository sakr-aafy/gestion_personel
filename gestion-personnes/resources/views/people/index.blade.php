@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-list"></i> Liste des Personnes</h2>

    <div class="d-flex align-items-center gap-4">
        <!-- Bouton Ajouter une personne -->
        <a href="{{ route('people.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter une personne
        </a>

        <!-- Informations utilisateur + déconnexion (seulement si connecté) -->
        @auth
            <div class="d-flex align-items-center text-white">
                <span class="me-3">
                    <i class="fas fa-user-circle"></i>
                    {{ Auth::user()->name }}
                </span>

                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </button>
                </form>
            </div>
        @endauth
    </div>
</div>

<!-- Formulaire de recherche -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('people.index') }}" method="GET" class="row g-3">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control"
                       placeholder="Rechercher par nom, prénom, email ou téléphone..."
                       value="{{ request('search') }}">
            </div>

            <div class="col-md-4">
                <select name="ville" class="form-select">
                    <option value="">Toutes les villes</option>
                    @foreach($villes as $ville)
                        <option value="{{ $ville }}" {{ request('ville') == $ville ? 'selected' : '' }}>
                            {{ $ville }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Rechercher
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tableau des personnes -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Ville</th>
                        <th>Date de naissance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($people as $person)
                        <tr>
                            <td>{{ $person->id }}</td>
                            <td>{{ $person->nom }}</td>
                            <td>{{ $person->prenom }}</td>
                            <td>{{ $person->email }}</td>
                            <td>{{ $person->telephone ?? '-' }}</td>
                            <td>{{ $person->ville ?? '-' }}</td>
                            <td>{{ $person->date_naissance ? $person->date_naissance->format('d/m/Y') : '-' }}</td>
                            <td>
                                <a href="{{ route('people.edit', $person) }}" class="btn btn-sm btn-warning" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('people.destroy', $person) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette personne ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">Aucune personne trouvée</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $people->links() }}
        </div>
    </div>
</div>
@endsection