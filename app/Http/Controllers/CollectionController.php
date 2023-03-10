<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollectionStoreRequest;
use App\Http\Requests\CollectionUpdateRequest;
use App\Models\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CollectionController extends Controller
{
    public function index(Request $request): View
    {
        $collections = Collection::all();

        return view('collection.index', compact('collections'));
    }

    public function create(Request $request): View
    {
        return view('collection.create');
    }

    public function store(CollectionStoreRequest $request): RedirectResponse
    {
        $collection = Collection::create($request->validated());

        $request->session()->flash('collection.id', $collection->id);

        return redirect()->route('collection.index');
    }

    public function show(Request $request, Collection $collection): View
    {
        return view('collection.show', compact('collection'));
    }

    public function edit(Request $request, Collection $collection): View
    {
        return view('collection.edit', compact('collection'));
    }

    public function update(CollectionUpdateRequest $request, Collection $collection): RedirectResponse
    {
        $collection->update($request->validated());

        $request->session()->flash('collection.id', $collection->id);

        return redirect()->route('collection.index');
    }

    public function destroy(Request $request, Collection $collection): RedirectResponse
    {
        $collection->delete();

        return redirect()->route('collection.index');
    }
}
