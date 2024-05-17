<div class="h-screen flex items-center justify-center font-mono">
    <div class="text-2xl selection:bg-red-700 selection:text-white">
        <div wire:poll.10s>
            <div class="flex justify-between">
                <div class="relative ml-8 w-32 text-gray-600">
                    Today
                    @if ($isActive)
                        <div class="absolute bg-red-600 rounded-full" style="width: 10px; height: 10px; left: -30px; top: 12px;"></div>
                    @endif
                </div>
                <div class="ml-8 w-32 text-gray-600">
                    Month
                </div>
                <div class="ml-8 w-32 text-gray-600">
                    Pace
                </div>
            </div>

            <div class="mt-4 flex justify-between">
                <div class="ml-8 w-32">
                    {{ $tgoal }}%
                </div>
                <div class="ml-8 w-32">
                    {{ $goal }}%
                </div>
                <div class="w-32 ml-8 {{ $paceClass }}">
                    {{ abs($pace) }}h
                </div>
            </div>
        </div>
    </div>

    @include('menu', ['active' => 'today'])
</div>
