<div class="h-screen flex items-center justify-center font-mono">
    <div class="text-2xl selection:bg-red-700 selection:text-white">
        <div wire:poll.10s>
            <div class="flex justify-start">
                <div class="w-24 relative text-gray-600">
                    Today
                    @if ($isActive)
                        <div class="absolute bg-red-600 rounded-full" style="width: 10px; height: 10px; left: -30px; top: 12px;"></div>
                    @endif
                </div>
                <div class="ml-8 w-24 text-right">{{ $tgoal }}%</div>
            </div>

            <div class="mt-4 flex justify-start">
                <div class="w-24 text-gray-600">Month</div>
                <div class="ml-8 w-24 text-right">{{ $goal }}%</div>
            </div>
        </div>

        <div class="mt-4 flex justify-start text-gray-600">
            <div class="w-24">Pace</div>

            <div class="w-24 ml-8 text-right {{ $paceClass }}">
                {{ $pace }}
            </div>
            &nbsp;
        </div>
    </div>

    <a href="/month-review" class="absolute text-gray-600 hover:text-gray-100 hover:border-b hover:cursor-pointer" style="bottom: 24px; right: 48px;">Month review</a>
</div>
