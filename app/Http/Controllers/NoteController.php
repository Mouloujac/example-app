<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteStoreRequest;
use App\Http\Requests\NoteUpdateRequest;
use App\Models\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NoteController extends Controller
{
    public function index(Request $request): View
    {
        $notes = Note::all();

        return view('note.index', compact('notes'));
    }

    public function create(Request $request): View
    {
        return view('note.create');
    }

    public function store(NoteStoreRequest $request)
    {
        $note = Note::create($request->validated());

        return response()->json($note, 201);
    }

    public function show(Request $request, Note $note): View
    {
        return view('note.show', compact('note'));
    }

    public function edit(Request $request, Note $note): View
    {
        return view('note.edit', compact('note'));
    }

    public function update(NoteUpdateRequest $request, Note $note)
    {
        $note->update($request->validated());


        return response()->noContent();
    }

    public function destroy(Request $request, Note $note)
    {
        // $user = Auth::user();
        // $note->collection()->whereHas($user)->exist()->delete();
        
        $note->delete();
        return response()->noContent();
    }
}
