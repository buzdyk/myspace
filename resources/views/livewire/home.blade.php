<div>
    <div wire:poll.600s class="h-screen flex items-center justify-center font-mono">
        <div class="text-2xl selection:bg-red-700 selection:text-white">
            <div class="flex">
                <div>
                    <div><span class="underline">Today</span></div>
                    <div class="mt-2">{{ $tgoal }}%</div>
                    <div class="mt-2 text-gray-800 hover:text-gray-300">${{ $tearned }}</div>
                    <div class="mt-2 text-gray-800 hover:text-gray-300">{{ $thours }} hours</div>
                </div>

                <div class="ml-36">
                    <div class="underline">Month</div>
                    <div class="mt-2">{{ $goal }}%</div>
                    <div>
                    </div>

                    <div class="mt-2 text-gray-800 hover:text-gray-300">${{ $earned }}</div>
                    <div class="mt-2 text-gray-800 hover:text-gray-300">{{ $hours }} hours</div>
                </div>
            </div>
        </div>
    </div>
</div>
