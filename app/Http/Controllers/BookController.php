<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;

class BookController extends Controller
{
    public function index(Request $request)
    {
       return Book::all();
    }

    public function create(Request $request): View
    {
        return view('book.create');
    }

    public function store(BookStoreRequest $request): RedirectResponse
    {
        $book = Book::create($request->validated());

        return redirect()->route('book.index');
    }

    public function show(Request $request, Book $book): View
    {
        return view('book.show', compact('book'));
    }

    public function edit(Request $request, Book $book): View
    {
        return view('book.edit', compact('book'));
    }

    public function update(BookUpdateRequest $request, Book $book): RedirectResponse
    {
        $book->update($request->validated());

        

        return redirect()->route('book.index');
    }

    public function destroy(Request $request, Book $book)
    {
        
        $book->delete();

        return redirect()->route('book.index');
    }
}
