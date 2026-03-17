<div class="flex items-center space-x-3">
    <div class="flex text-yellow-400 text-xl">
        @for ($i = 1; $i <= 5; $i++)
            @if ($i <= $rating)
                ★
            @else
                ☆
            @endif
        @endfor
    </div>
    <span class="text-slate-400">
        {{ $rating }}
        ({{ $numReviews }} reviews)
    </span>
</div>
