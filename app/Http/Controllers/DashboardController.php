<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $reviewsPerDay = Review::selectRaw('DATE(created_at) as date, count(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', [
            'users' => User::count(),
            'books' => Book::count(),
            'reviews' => Review::count(),
            'avgRating' => Review::avg('rating'),
            'reviewsPerDay' => $reviewsPerDay,
        ]);
    }
}
