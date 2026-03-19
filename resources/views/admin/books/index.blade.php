@extends('admin.layout')

@section('content')
    <div class="max-w-6xl mx-auto">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-white">Books</h1>

            <button onclick="openModal()" class="bg-indigo-600 px-5 py-2 rounded-lg shadow hover:bg-indigo-500">
                + Add Book
            </button>
        </div>

        <!-- Card -->
        <div class="bg-slate-800 border border-slate-700 rounded-2xl shadow-lg overflow-hidden p-4">
            <form method="GET" class="mb-6 flex flex-wrap gap-3 items-center">

                <!-- Search -->
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search books..."
                    class="bg-slate-800 border border-slate-700 text-white px-4 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500" />

                <!-- Rating Filter -->
                <select name="rating" class="bg-slate-800 border border-slate-700 text-white px-4 py-2 rounded-lg">
                    <option value="">All Ratings</option>
                    <option value="4">4+ Stars</option>
                    <option value="3">3+ Stars</option>
                </select>

                <!-- Sort -->
                <select name="sort" class="bg-slate-800 border border-slate-700 text-white px-4 py-2 rounded-lg">
                    <option value="">Newest</option>
                    <option value="rating">Highest Rating</option>
                    <option value="reviews">Most Reviewed</option>
                </select>

                <button class="bg-indigo-600 px-4 py-2 rounded-lg hover:bg-indigo-500">
                    Apply
                </button>

            </form>

            <table class="w-full text-sm">

                <!-- Table Head -->
                <thead class="bg-slate-900/50 text-slate-400 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-left">Title</th>
                        <th class="px-6 py-4 text-left">Author</th>
                        <th class="px-6 py-4 text-left">Cover</th>
                        <th class="px-6 py-4 text-center">Reviews</th>
                        <th class="px-6 py-4 text-center">Rating</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="divide-y divide-slate-700">
                    @foreach ($books as $book)
                        <tr class="hover:bg-slate-700/40 transition">

                            <!-- Title -->
                            <td class="px-6 py-4 text-white font-medium">
                                {{ $book->title }}
                            </td>

                            <!-- Author -->
                            <td class="px-6 py-4 text-white font-medium">
                                {{ $book->author }}
                            </td>


                            <td class="px-6 py-4 flex items-center gap-3">
                                <img src="{{ $book->cover }}" class="w-10 h-14 object-cover rounded">
                                <span>{{ $book->title }}</span>
                            </td>



                            <!-- Reviews Count -->
                            <td class="px-6 py-4 text-center text-slate-300">
                                {{ $book->reviews_count }}
                            </td>

                            <!-- Rating -->
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-1 text-yellow-400">
                                    ⭐ {{ round($book->reviews_avg_rating, 1) ?? '0.0' }}
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 text-right">
                                <form method="POST" action="/admin/books/{{ $book->id }}">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Are you sure you want to delete this book?')"
                                        class="text-red-400 hover:text-red-300 text-sm font-medium transition">
                                        Delete
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            <div class="bg-slate-800 border border-slate-700 rounded-lg px-4 py-2">
                {{ $books->links() }}
            </div>
        </div>

    </div>
@endsection

<div id="modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center">

    <div class="bg-slate-800 p-6 rounded-2xl w-full max-w-md">

        <h2 class="text-lg font-semibold mb-4">Add Book</h2>

        <form method="POST" action="/admin/books" enctype="multipart/form-data">
            @csrf

            <!-- Title -->
            <input name="title" placeholder="Title"
                class="w-full mb-3 bg-slate-900 border border-slate-700 px-3 py-2 rounded-lg text-white" />

            <!-- Author -->
            <input name="author" placeholder="Author"
                class="w-full mb-3 bg-slate-900 border border-slate-700 px-3 py-2 rounded-lg text-white" />


            <!-- Description -->

            <textarea name="description" id=""
                class="w-full mb-3 bg-slate-900 border border-slate-700 px-3 py-2 rounded-lg text-white"></textarea>

            <!-- 📸 Image Preview -->
            <label class="cursor-pointer">
                <img id="preview" class="hidden w-full h-48 object-cover rounded-lg mb-2 border border-slate-700" />

                <span class="block text-center text-slate-400 text-sm">
                    Click to upload cover
                </span>

                <input type="file" name="cover" accept="image/*" onchange="previewImage(event)" class="hidden" />
            </label>

            <!-- 📁 File Upload -->
            {{-- <input type="file" name="cover" accept="image/*" onchange="previewImage(event)"
                class="w-full mb-4 text-sm text-slate-400 file:bg-slate-700 file:border-0 file:px-3 file:py-2 file:rounded-lg file:text-white hover:file:bg-slate-600" />
            --}}

            <!-- Actions -->
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="text-slate-400">
                    Cancel
                </button>

                <button class="bg-indigo-600 px-4 py-2 rounded-lg hover:bg-indigo-500">
                    Save
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('modal').classList.remove('hidden');
        document.getElementById('modal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
        document.getElementById('modal').classList.remove('flex');
    }

    function previewImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];

        if (!file) return;

        const url = URL.createObjectURL(file);
        preview.src = url;
        preview.classList.remove('hidden');

        preview.onload = () => {
            URL.revokeObjectURL(url); // 🧠 free memory
        };
    }

    // function previewImage(event) {
    //     const input = event.target;
    //     const preview = document.getElementById('preview');

    //     if (input.files && input.files[0]) {
    //         const reader = new FileReader();

    //         reader.onload = function(e) {
    //             preview.src = e.target.result;
    //             preview.classList.remove('hidden');
    //         }

    //         reader.readAsDataURL(input.files[0]);
    //     }
    // }
</script>