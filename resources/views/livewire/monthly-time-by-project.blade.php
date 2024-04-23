<div class="h-screen flex items-center justify-center font-mono">
    <div class="w-1/2 text-2xl selection:bg-red-700 selection:text-white">
        @if ($projects->count() === 0)
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

            @while ($project = $projects->next())
                <div class="flex justify-between">
                    <div class="w-2/4">{{ $project->projectTitle }}</div>
                    <div class="w-1/4 text-left">{{ round($project->seconds / 3600, 2) }}</div>
                    <div class="w-1/4 text-left">
                        ${{ number_format($project->getHours() * $hourlyRate) }}
                    </div>
                </div>
            @endwhile

            <div class="flex justify-between mt-4">
                <div class="w-2/4">&nbsp;</div>
                <div class="w-1/4 text-left">{{ $totalHours }}</div>
                <div class="w-1/4 text-left">
                    ${{ number_format($totalHours * $hourlyRate) }}
                </div>
            </div>

            <div class="mt-16">
                {{ $dayOfMonth->format('F, Y') }}
                <span class="text-gray-600 hover:text-gray-100 hover:border-b cursor-pointer">&lt;</span>
                <span class="text-gray-600 hover:text-gray-100 hover:border-b cursor-pointer">&gt;</span>
            </div>
        @endif
    </div>

    <a href="/" class="absolute text-gray-600 hover:text-gray-100 hover:border-b hover:cursor-pointer" style="bottom: 24px; right: 48px;">Goals</a>
</div>
