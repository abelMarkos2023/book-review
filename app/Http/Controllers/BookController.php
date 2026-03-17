<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Book::when(request('title'), fn ($q, $title) => $q->title($title))
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        $filter = request('filter');

        $books = match ($filter) {
            'top_rated' => $query->orderBy('reviews_avg_rating', 'desc'),
            'popular' => $query->orderBy('reviews_count', 'desc'),
            default => $query->latest(),
        };

        $books = $books->paginate();

        return view('books.index', compact('books', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|numeric|between:1,5',
            'review' => 'required|string|max:255',
        ]);

        $request->user()->reviews()->create([
            'book_id' => $request->book_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return redirect()->back()->with('success', 'Review added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->loadAvg('reviews', 'rating');
        $reviews = $book->reviews()->with('user')->latest()->paginate(4);

        return view('books.show', compact('book', 'reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
