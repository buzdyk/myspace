<div wire:poll.60s class="h-screen flex items-center justify-center font-mono">
    <div class="text-2xl selection:bg-red-700 selection:text-white">
        <div class="flex">
            <div>
                <div><span class="underline">Today</span></div>
                <div class="mt-2">{{ $tgoal }}%</div>
                <div class="mt-2 text-white hover:text-black">${{ $tearned }}</div>
                <div class="mt-2 text-white hover:text-black">{{ $thours }} hours</div>
            </div>

            <div class="ml-36">
                <div class="underline">Month</div>
                <div class="mt-2">{{ $goal }}%</div>
                <div>
                </div>

                <div class="mt-2 text-white hover:text-black">${{ $earned }}</div>
                <div class="mt-2 text-white hover:text-black">{{ $hours }} hours</div>
            </div>
        </div>
    </div>
</div>
