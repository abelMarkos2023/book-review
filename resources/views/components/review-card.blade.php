@props(['review'])

<div class="mt-4 bg-slate-900 p-6 rounded-2xl border border-slate-800" x-data="{ editing: false }">

    {{-- Display Mode --}}
    <div x-show="!editing">

        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-indigo-400">
                {{ $review->user?->name ?? 'Anonymous' }}
            </h3>

            <div class="text-yellow-400">
                @for ($i = 1; $i <= 5; $i++)
                    {{ $i <= $review->rating ? '★' : '☆' }}
                @endfor
            </div>
        </div>

        <p class="text-slate-300 leading-relaxed">
            {{ $review->review }}
        </p>

        <div class="flex items-center justify-between mt-4">
            <p class="text-xs text-slate-500">
                {{ $review->created_at->diffForHumans() }}
            </p>

            @can('update', $review)
                <div class="flex items-center gap-3">
                    <button @click="editing = true" class="text-xs text-slate-400 hover:text-indigo-400 transition">
                        ✏️ Edit
                    </button>

                    <form method="POST" action="{{ route('reviews.destroy', $review) }}"
                        onsubmit="return confirm('Are you sure you want to delete this review?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-slate-400 hover:text-red-400 transition">
                            🗑️ Delete
                        </button>
                    </form>
                </div>
            @endcan
        </div>

    </div>

    {{-- Edit Mode --}}
    @can('update', $review)
        <div x-show="editing" x-cloak>

            <form method="POST" action="{{ route('reviews.update', $review) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Rating</label>
                    <select name="rating"
                        class="w-full bg-slate-800 border border-slate-700 text-white rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @for ($r = 5; $r >= 1; $r--)
                            <option value="{{ $r }}" {{ $review->rating == $r ? 'selected' : '' }}>
                                {{ str_repeat('★', $r) }}{{ str_repeat('☆', 5 - $r) }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Your Review</label>
                    <textarea name="review" rows="3"
                        class="w-full bg-slate-800 border border-slate-700 text-white placeholder-slate-500 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none">{{ $review->review }}</textarea>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition shadow-lg shadow-indigo-500/25">
                        Save Changes
                    </button>

                    <button type="button" @click="editing = false"
                        class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-medium rounded-lg transition border border-slate-700">
                        Cancel
                    </button>
                </div>
            </form>

        </div>
    @endcan

</div>
