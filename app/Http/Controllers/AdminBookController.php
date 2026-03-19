<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class AdminBookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query()->withCount('reviews')->withAvg('reviews', 'rating');

        // 🔍 Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('author', 'like', "%{$request->search}%");
            });
        }

        // 🎯 Filter (by rating)
        if ($request->rating) {
            $query->having('reviews_avg_rating', '>=', $request->rating);
        }

        // 🔽 Sort
        if ($request->sort === 'rating') {
            $query->orderByDesc('reviews_avg_rating');
        } elseif ($request->sort === 'reviews') {
            $query->orderByDesc('reviews_count');
        } else {
            $query->latest();
        }

        $books = $query->paginate(10)->withQueryString();

        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'cover' => 'nullable|image|max:2048',
        ]);

        // $book = Book::create($request->all());

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Book::create($data);

        return redirect('/admin/books');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return back()->with('success', 'Book deleted successfully!');
    }
}
