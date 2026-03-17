@extends('layouts.books-layout')
{{-- {{ dd($book) }} --}}
@section('content')
    <div class="bg-slate-950 text-white min-h-screen pb-20">

        <div class="mt-8 max-w-6xl mx-auto px-6">

            <!-- BOOK HEADER -->
            <div class="grid md:grid-cols-3 gap-12">

                <!-- Cover -->
                <div>
                    <div class="h-[420px] bg-slate-800 rounded-2xl shadow-2xl"></div>
                </div>

                <!-- Book Info -->
                <div class="md:col-span-2 space-y-6">

                    <h1 class="text-4xl font-bold">{{ $book->title }}</h1>

                    <p class="text-slate-400 text-lg">
                        by <span class="text-indigo-400 font-medium">{{ $book->author }}</span>
                    </p>

                    <!-- Rating -->
                    <x-stars :rating="round($book->reviews_avg_rating, 1)" :numReviews="$book->reviews()->count()" />

                    <p class="text-slate-300 leading-relaxed">
                        {{ $book->description }}
                    </p>

                    <button
                        class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-xl transition shadow-lg shadow-indigo-600/30">
                        Write a Review
                    </button>

                </div>
            </div>

            <!-- REVIEWS SECTION -->
            <div class="mt-24">
                @auth
                    <x-add-review :book="$book" />
                @endauth

                <h2 class="text-3xl font-bold mb-10">Reviews</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">

                    @forelse($reviews as $review)
                        <x-review-card :review="$review" />
                    @empty
                        <p class="text-slate-400">No reviews yet. Be the first to review this book!</p>
                    @endforelse

                </div>

                <div class="mt-8">
                    {{ $reviews->links() }}
                </div>

            </div>

        </div>

    </div>
@endsection
