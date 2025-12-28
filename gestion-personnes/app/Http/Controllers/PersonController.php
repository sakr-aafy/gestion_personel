<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index(Request $request)
    {
        $query = Person::query();

        // Recherche
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%");
            });
        }

        // Filtrage par ville
        if ($request->has('ville') && $request->ville != '') {
            $query->where('ville', $request->ville);
        }

        $people = $query->orderBy('created_at', 'desc')->paginate(10);
        $villes = Person::distinct()->pluck('ville')->filter();

        return view('people.index', compact('people', 'villes'));
    }

    public function create()
    {
        return view('people.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:people,email',
            'telephone' => 'nullable|string|max:20',
            'ville' => 'nullable|string|max:255',
            'date_naissance' => 'nullable|date'
        ]);

        Person::create($validated);

        return redirect()->route('people.index')
            ->with('success', 'Personne ajoutée avec succès!');
    }

    public function edit(Person $person)
    {
        return view('people.edit', compact('person'));
    }

    public function update(Request $request, Person $person)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:people,email,' . $person->id,
            'telephone' => 'nullable|string|max:20',
            'ville' => 'nullable|string|max:255',
            'date_naissance' => 'nullable|date'
        ]);

        $person->update($validated);

        return redirect()->route('people.index')
            ->with('success', 'Personne modifiée avec succès!');
    }

    public function destroy(Person $person)
    {
        $person->delete();

        return redirect()->route('people.index')
            ->with('success', 'Personne supprimée avec succès!');
    }
}