<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollectionStoreRequest;
use App\Http\Requests\CollectionUpdateRequest;
use App\Models\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    public function index(Request $request)
    {   
        $user = Auth::id();
        return auth()->user()->books()->get();
        $collections = Collection::where('user_id', $user)
                    ->join('books', 'books.id', '=' ,'collections.book_id')
                    ->get();

        return response()->json($collections);
    }

    public function create(Request $request): View
    {
        return view('collection.create');
    }

    public function store(CollectionStoreRequest $request): RedirectResponse
    {
        $collection = Collection::create($request->validated());


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


        return redirect()->route('collection.index');
    }

    public function destroy(Request $request, Collection $collection)
    {
        $user_id = Auth::id();
        if(Auth::id() !== $collection->user_id) {
            abort(403);
        }

        $collection->delete();

        return response()->noContent();
    }
}
