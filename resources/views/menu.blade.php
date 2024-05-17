<?php
    $pages = ['today' => 'Today', 'month-review' => 'Month Review', 'wishlist' => 'Wishlist'];
    $active = $active ?? '??';

    if (env('WISHLIST_ON') === false) {
        unset($pages['wishlist']);
    }
?>
<div class="w-full absolute text-xs" style="bottom: 40px; left: 0;">
    <div class="flex justify-around">
        <div class="flex justify-between">
            @foreach ($pages as $path => $label)
                @if ($path === $active)
                    <span class="inline-block mr-12 text-gray-400">
                        {{ $label }}
                    </span>
                @else
                    <a href="/{{ $path }}" class="inline-block mr-12 text-gray-600 hover:text-gray-100 hover:border-b">
                        {{ $label }}
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</div>
