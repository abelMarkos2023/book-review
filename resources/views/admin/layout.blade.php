<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>{{ config('app.name', 'BookVerse') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="bg-slate-900 text-white flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-800 min-h-screen p-4">
        <h2 class="text-xl font-bold mb-6">Admin Panel</h2>

        <nav class="space-y-2">
            <a href="/admin/dashboard" class="block p-2 rounded hover:bg-slate-700">Dashboard</a>
            <a href="/admin/books" class="block p-2 rounded hover:bg-slate-700">Books</a>
            <a href="/admin/users" class="block p-2 rounded hover:bg-slate-700">Users</a>
        </nav>
    </aside>

    <!-- Content -->
    <main class="flex-1 p-6">

        @if (session('success'))
            <div class="mb-4 bg-green-500/20 border border-green-500/30 text-green-300 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>

</html>