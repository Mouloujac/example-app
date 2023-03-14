<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentaireStoreRequest;
use App\Http\Requests\CommentaireUpdateRequest;
use App\Models\Commentaire;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommentaireController extends Controller
{
    public function index(Request $request): View
    {
        $commentaires = Commentaire::all();

        return view('commentaire.index', compact('commentaires'));
    }

    public function create(Request $request): View
    {
        return view('commentaire.create');
    }

    public function store(CommentaireStoreRequest $request)
    {
        $commentaire = Commentaire::create($request->validated());

        return response()->json($commentaire, 201);
    }

    public function show(Request $request, Commentaire $commentaire): View
    {
        return view('commentaire.show', compact('commentaire'));
    }

    public function edit(Request $request, Commentaire $commentaire): View
    {
        return view('commentaire.edit', compact('commentaire'));
    }

    public function update(CommentaireUpdateRequest $request, Commentaire $commentaire): RedirectResponse
    {
        $commentaire->update($request->validated());

        return redirect()->route('commentaire.index');
    }

    public function destroy(Request $request, Commentaire $commentaire)
    {
        $commentaire->delete();
        return response()->noContent();
    }
}
