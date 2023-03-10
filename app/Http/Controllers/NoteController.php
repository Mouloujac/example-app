<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteStoreRequest;
use App\Http\Requests\NoteUpdateRequest;
use App\Models\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function store(NoteStoreRequest $request): RedirectResponse
    {
        $note = Note::create($request->validated());

        $request->session()->flash('note.id', $note->id);

        return redirect()->route('note.index');
    }

    public function show(Request $request, Note $note): View
    {
        return view('note.show', compact('note'));
    }

    public function edit(Request $request, Note $note): View
    {
        return view('note.edit', compact('note'));
    }

    public function update(NoteUpdateRequest $request, Note $note): RedirectResponse
    {
        $note->update($request->validated());

        $request->session()->flash('note.id', $note->id);

        return redirect()->route('note.index');
    }

    public function destroy(Request $request, Note $note): RedirectResponse
    {
        $note->delete();

        return redirect()->route('note.index');
    }
}
