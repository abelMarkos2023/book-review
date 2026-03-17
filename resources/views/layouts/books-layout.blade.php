<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'BookVerse') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-950 text-white antialiased space-y-20">

    <!-- ================= NAVBAR ================= -->
    <header class="sticky w-full top-0 z-50 bg-slate-950/90 backdrop-blur-lg border-b border-slate-800 ">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between h-16">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight">
                    📚 <span class="text-indigo-400">Book</span>Verse
                </a>

                <!-- Desktop Nav -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
                    <a href="{{ route('books.index') }}" class="hover:text-indigo-400 transition">
                        Books
                    </a>

                    @auth
                        <a href="{{ route('home') }}" class="hover:text-indigo-400 transition">
                            Dashboard
                        </a>

                        <a href="{{ route('profile.edit') }}" class="hover:text-indigo-400 transition">
                            Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="hover:text-red-400 transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-indigo-400 transition">
                            Login
                        </a>

                        <a href="{{ route('register') }}"
                            class="bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded-lg transition">
                            Get Started
                        </a>
                    @endauth
                </nav>

                <!-- Mobile Button -->
                <button id="mobileMenuBtn" class="md:hidden">
                    ☰
                </button>

            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-slate-900 border-t border-slate-800">
            <div class="px-6 py-4 space-y-4 text-sm">

                <a href="{{ route('books.index') }}" class="block hover:text-indigo-400">
                    Books
                </a>

                @auth
                    <a href="{{ route('home') }}" class="block hover:text-indigo-400">
                        Dashboard
                    </a>

                    <a href="{{ route('profile.edit') }}" class="block hover:text-indigo-400">
                        Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-left w-full hover:text-red-400">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block hover:text-indigo-400">
                        Login
                    </a>

                    <a href="{{ route('register') }}" class="block text-indigo-400">
                        Get Started
                    </a>
                @endauth

            </div>
        </div>

    </header>


    <!-- ================= MAIN CONTENT ================= -->
    <main class="pt-24">
        @yield('content')
    </main>


    <!-- ================= FOOTER ================= -->
    <footer class="border-t border-slate-800 mt-20 py-10">
        <div class="max-w-7xl mx-auto px-6 text-sm text-slate-400 flex flex-col md:flex-row justify-between gap-6">

            <p>
                © {{ date('Y') }} BookVerse. All rights reserved.
            </p>

            <div class="flex gap-6">
                <a href="#" class="hover:text-white transition">Privacy</a>
                <a href="#" class="hover:text-white transition">Terms</a>
                <a href="#" class="hover:text-white transition">Contact</a>
            </div>

        </div>
    </footer>


    <!-- ================= MOBILE MENU SCRIPT ================= -->
    <script>
        const btn = document.getElementById('mobileMenuBtn');
        const menu = document.getElementById('mobileMenu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>

</body>

</html>
