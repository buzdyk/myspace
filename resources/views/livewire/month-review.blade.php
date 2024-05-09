<div class="h-screen flex items-center justify-center font-mono">
    <div class="w-1/2 text-2xl selection:bg-red-700 selection:text-white">
        @if (count($projects) === 0)
            <h1>Time not found for the month</h1>
        @else
            <div class="flex justify-between mb-4 text-gray-600">
                <div class="w-2/4">
                    <span>Project</span>
                </div>
                <div class="w-1/4 text-left">
                    <span>Hours</span>
                </div>
                <div class="w-1/4">Earned</div>
            </div>

            @foreach ($projects as $project)
                <div class="flex justify-between">
                    <div class="w-2/4">{{ $project['projectTitle'] }}</div>
                    <div class="w-1/4 text-left">{{ $project['hours'] }}</div>
                    <div class="w-1/4 text-left">
                        ${{ number_format($project['hours'] * $hourlyRate) }}
                    </div>
                </div>
            @endforeach

            <div class="flex justify-between mt-4">
                <div class="w-2/4">&nbsp;</div>
                <div class="w-1/4 text-left">{{ $totalHours }}</div>
                <div class="w-1/4 text-left">
                    ${{ number_format($totalHours * $hourlyRate) }}
                </div>
            </div>

            <div class="mt-16">
                {{ $dayOfMonth->format('F, Y') }}
                <span wire:click="sub" class="text-gray-600 hover:text-gray-100 hover:border-b cursor-pointer">&lt;</span>
                <span wire:click="add" class="text-gray-600 hover:text-gray-100 hover:border-b cursor-pointer">&gt;</span>
            </div>
        @endif

    </div>


    <div class="absolute text-xs text-gray-600 hover:text-white" style="right:48px">
        <div class="">
            @foreach($dailyHours as $dh)
                <div class="mb-1 flex justify-start">
                    <span>{{ $dh['day'] }}</span>
                    <span class="ml-2">{{ $dh['hours'] }}</span>
                </div>
            @endforeach
        </div>

    </div>
    <a href="/" class="absolute text-gray-600 hover:text-gray-100 hover:border-b hover:cursor-pointer" style="bottom: 24px; right: 48px;">Goals</a>
</div>
