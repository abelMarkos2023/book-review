@extends('admin.layout')

@section('content')

    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

        <div class="bg-slate-800 p-4 rounded-xl">
            <p class="text-slate-400">Users</p>
            <h2 class="text-2xl">{{ $users }}</h2>
        </div>

        <div class="bg-slate-800 p-4 rounded-xl">
            <p class="text-slate-400">Books</p>
            <h2 class="text-2xl">{{ $books }}</h2>
        </div>

        <div class="bg-slate-800 p-4 rounded-xl">
            <p class="text-slate-400">Reviews</p>
            <h2 class="text-2xl">{{ $reviews }}</h2>
        </div>

        <div class="bg-slate-800 p-4 rounded-xl">
            <p class="text-slate-400">Avg Rating</p>
            <h2 class="text-2xl">{{ number_format($avgRating, 1) }}</h2>
        </div>

    </div>

    <canvas id="reviewsChart" height="100"></canvas>

    <script>
        const ctx = document.getElementById('reviewsChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($reviewsPerDay->pluck('date')) !!},
                datasets: [{
                    label: 'Reviews per Day',
                    data: {!! json_encode($reviewsPerDay->pluck('count')) !!},
                    borderColor: '#6366f1',
                    tension: 0.6
                }]
            }
        });
    </script>
@endsection