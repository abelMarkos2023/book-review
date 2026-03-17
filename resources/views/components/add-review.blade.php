@props(['book'])

<div class="max-w-xl bg-slate-800/50 border border-slate-700 rounded-2xl p-8 shadow-lg mb-12">

    <h2 class="text-xl font-semibold text-white mb-6">
        ✍️ Write a Review
    </h2>

    <form class="space-y-5" method="POST" action="{{ route('books.store') }}">
        @csrf

        <input type="hidden" name="book_id" value="{{ $book->id }}">

        {{-- Rating --}}
        <div>
            <label for="rating" class="block text-sm font-medium text-slate-300 mb-2">
                Rating
            </label>

            <select name="rating" id="rating"
                class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="" disabled selected>Select a rating</option>
                <option value="5">★★★★★ — Excellent</option>
                <option value="4">★★★★☆ — Great</option>
                <option value="3">★★★☆☆ — Good</option>
                <option value="2">★★☆☆☆ — Fair</option>
                <option value="1">★☆☆☆☆ — Poor</option>
            </select>

            <x-input-error :messages="$errors->get('rating')" class="mt-1" />
        </div>

        {{-- Review Text --}}
        <div>
            <label for="review" class="block text-sm font-medium text-slate-300 mb-2">
                Your Review
            </label>

            <textarea name="review" id="review" rows="4" placeholder="What did you think about the book?"
                class="w-full bg-slate-900 border border-slate-700 text-white placeholder-slate-500 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none">{{ old('review') }}</textarea>

            <x-input-error :messages="$errors->get('review')" class="mt-1" />
        </div>

        {{-- Submit Button --}}
        <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-medium py-2.5 rounded-lg transition shadow-lg shadow-indigo-500/25">
            Submit Review
        </button>
    </form>
</div>
