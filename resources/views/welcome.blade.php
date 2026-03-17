<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookVerse | Discover & Review Books</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-slate-950 text-white font-sans">

    <!-- ================= NAVBAR ================= -->
    <nav x-data="{ open: false }" class="fixed w-full z-50 bg-slate-900/80 backdrop-blur-md border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

            <h1 class="text-2xl font-bold text-indigo-400">BookVerse</h1>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-8 text-sm text-slate-300">
                <a href="/" class="hover:text-white transition">Home</a>
                <a href="/books" class="hover:text-white transition">Books</a>
                <a href="/reviews" class="hover:text-white transition">Reviews</a>
                <a href="{{ route('login') }}"class="hover:text-white transition">Login</a>
            </div>

            <!-- Mobile Button -->
            <button @click="open = !open" class="md:hidden text-slate-300 focus:outline-none">
                ☰
            </button>
        </div>

        <!-- Mobile Dropdown -->
        <div x-show="open" x-transition
            class="md:hidden bg-slate-900 border-t border-slate-800 px-6 py-4 space-y-4 text-slate-300">
            <a href="/" class="block hover:text-white">Home</a>
            <a href="/books" class="block hover:text-white">Books</a>
            <a href="/reviews" class="block hover:text-white">Reviews</a>
            <a href="{{ route('login') }}" class="block hover:text-white">Login</a>
        </div>
    </nav>

    <!-- ================= HERO ================= -->
    <section class="min-h-screen flex items-center justify-center text-center px-6">
        <div class="max-w-3xl">
            <h2 class="text-5xl md:text-6xl font-bold leading-tight mb-6">
                Discover. Review. <span class="text-indigo-500">Share Stories.</span>
            </h2>

            <p class="text-slate-400 text-lg mb-10">
                Explore thousands of books, write honest reviews, and connect with passionate readers around the world.
            </p>

            <div class="flex justify-center gap-6">
                <a href="/books"
                    class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 rounded-xl text-white font-medium transition shadow-lg shadow-indigo-600/30">
                    Browse Books
                </a>

                <a href="/login"
                    class="px-8 py-4 border border-slate-700 hover:border-indigo-500 rounded-xl text-slate-300 hover:text-white transition">
                    Write a Review
                </a>
            </div>
        </div>
    </section>

    <!-- ================= FEATURED BOOKS ================= -->
    <section class="py-24 bg-slate-900">
        <div class="max-w-7xl mx-auto px-6">
            <h3 class="text-3xl font-bold mb-12 text-center">Featured Books</h3>

            <div class="grid md:grid-cols-3 gap-10">
                @for ($i = 0; $i < 3; $i++)
                    <div
                        class="bg-slate-800 rounded-2xl p-6 hover:-translate-y-2 transition duration-300 shadow-lg hover:shadow-indigo-500/20">
                        <div class="h-56 bg-slate-700 rounded-xl mb-6"></div>
                        <h4 class="text-xl font-semibold mb-2">Book Title</h4>
                        <p class="text-slate-400 text-sm mb-4">Short description of the book that gives readers an idea
                            of what it's about.</p>
                        <span class="text-indigo-400 text-sm">⭐ 4.8 Rating</span>
                    </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- ================= WHY US ================= -->
    <section class="py-24">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h3 class="text-3xl font-bold mb-16">Why BookVerse?</h3>

            <div class="grid md:grid-cols-3 gap-12">
                <div>
                    <div class="text-indigo-500 text-4xl mb-4">📚</div>
                    <h4 class="text-xl font-semibold mb-3">Vast Collection</h4>
                    <p class="text-slate-400">Discover books across all genres and eras curated by passionate readers.
                    </p>
                </div>

                <div>
                    <div class="text-indigo-500 text-4xl mb-4">✍️</div>
                    <h4 class="text-xl font-semibold mb-3">Honest Reviews</h4>
                    <p class="text-slate-400">Share your thoughts and help others find their next great read.</p>
                </div>

                <div>
                    <div class="text-indigo-500 text-4xl mb-4">🌍</div>
                    <h4 class="text-xl font-semibold mb-3">Community Driven</h4>
                    <p class="text-slate-400">Connect with readers worldwide and explore trending discussions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= CALL TO ACTION ================= -->
    <section class="py-24 bg-gradient-to-r from-indigo-600 to-purple-600 text-center">
        <div class="max-w-3xl mx-auto px-6">
            <h3 class="text-4xl font-bold mb-6">Ready to Join the Reading Revolution?</h3>
            <p class="mb-10 text-indigo-100">Create your free account and start reviewing your favorite books today.</p>

            <a href="#"
                class="px-10 py-4 bg-white text-indigo-700 font-semibold rounded-xl hover:scale-105 transition shadow-xl">
                Get Started
            </a>
        </div>
    </section>

    <!-- ================= FOOTER ================= -->
    <footer class="bg-slate-900 border-t border-slate-800 py-8 text-center text-slate-500 text-sm">
        © {{ date('Y') }} BookVerse. All rights reserved.
    </footer>

</body>

</html>
