@extends('layouts.books-layout')

@section('content')

    <div class="bg-slate-950 text-white min-h-screen pb-20">

        <div class="max-w-7xl mx-auto px-6">

            <!-- ================= HEADER ================= -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-12 gap-6">

                <div>
                    <h1 class="text-4xl font-bold">Discover Books</h1>
                    <p class="text-slate-400 mt-2">Explore our growing library of amazing reads.</p>
                </div>

                <!-- Search Bar -->
                <form method="GET" action="{{ route('books.index') }}" class="relative w-full md:w-96">
                    @if (request('filter'))
                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                    @endif
                    <input type="text" name="title" value="{{ request('title') }}" placeholder="Search books..."
                        class="w-full bg-slate-900 border border-slate-800 rounded-xl px-5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </form>

            </div>


            <!-- ================= FILTERS ================= -->
            <div class="flex flex-wrap gap-3 mb-12">

                <a href="{{ route('books.index') }}"
                    class="px-4 py-2 rounded-full text-sm border border-slate-700 hover:border-indigo-500 transition">
                    All
                </a>

                @foreach ($categories ?? [] as $category)
                    <a href="{{ route('books.index', ['category' => $category->id]) }}"
                        class="px-4 py-2 rounded-full text-sm border border-slate-700 hover:border-indigo-500 transition">
                        {{ $category->name }}
                    </a>
                @endforeach

            </div>


            <!-- ================= SORT TABS ================= -->
            <div class="flex gap-2 mb-10">

                <a href="{{ route('books.index', array_merge(request()->except('filter', 'page'))) }}"
                    class="px-5 py-2.5 rounded-lg text-sm font-medium transition
                          {{ !isset($filter) ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'bg-slate-900 text-slate-400 border border-slate-800 hover:border-indigo-500 hover:text-white' }}">
                    🕐 Latest
                </a>

                <a href="{{ route('books.index', array_merge(request()->except('page'), ['filter' => 'top_rated'])) }}"
                    class="px-5 py-2.5 rounded-lg text-sm font-medium transition
                          {{ ($filter ?? '') === 'top_rated' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'bg-slate-900 text-slate-400 border border-slate-800 hover:border-indigo-500 hover:text-white' }}">
                    ⭐ Top Rated
                </a>

                <a href="{{ route('books.index', array_merge(request()->except('page'), ['filter' => 'popular'])) }}"
                    class="px-5 py-2.5 rounded-lg text-sm font-medium transition
                          {{ ($filter ?? '') === 'popular' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'bg-slate-900 text-slate-400 border border-slate-800 hover:border-indigo-500 hover:text-white' }}">
                    🔥 Most Popular
                </a>

            </div>


            <!-- ================= BOOK GRID ================= -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">

                @forelse($books as $book)
                    <a href="{{ route('books.show', $book->id) }}"
                        class="group bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden hover:-translate-y-2 transition duration-300 hover:shadow-xl hover:shadow-indigo-500/20">

                        <!-- Cover -->
                        <div class="h-72 bg-slate-800 overflow-hidden">
                            @if ($book->cover)
                                <img src="{{ asset('storage/' . $book->cover) }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-6 space-y-3">

                            <h2 class="text-lg font-semibold group-hover:text-indigo-400 transition">
                                {{ $book->title }}
                            </h2>

                            <p class="text-sm text-slate-400">
                                {{ $book->author }}
                            </p>

                            <!-- Rating -->
                            <div class="flex items-center justify-between mt-3">

                                <div class="flex items-center gap-1.5">
                                    <div class="flex text-yellow-400 text-sm">
                                        @for ($i = 1; $i <= 5; $i++)
                                            {{ $i <= round($book->reviews_avg_rating) ? '★' : '☆' }}
                                        @endfor
                                    </div>
                                    <span class="text-sm font-medium text-slate-300">
                                        {{ round($book->reviews_avg_rating, 1) }}
                                    </span>
                                </div>

                                <span class="text-xs text-slate-500">
                                    {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
                                </span>

                            </div>

                            <!-- Date Added -->
                            <p class="text-xs text-slate-500 mt-2">
                                Added {{ $book->created_at->diffForHumans() }}
                            </p>

                        </div>

                    </a>

                @empty
                    <p class="text-slate-400 col-span-full">No books found.</p>
                @endforelse

            </div>


            <!-- ================= PAGINATION ================= -->
            <div class="mt-16">
                {{ $books->links() }}
            </div>

        </div>

    </div>

@endsection
