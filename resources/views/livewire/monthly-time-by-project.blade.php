<div class="h-screen flex items-center justify-center font-mono">
    <div class="w-1/2 text-2xl selection:bg-red-700 selection:text-white">
        @if ($projects->count() === 0)
            <h1>Time not found for the month</h1>
        @else
            <div class="flex justify-between mb-4">
                <div class="w-2/4">
                    <span>Project</span>
                </div>
                <div class="w-1/4 text-left">
                    <span>Hours</span>
                </div>
                <div class="w-1/4">&nbsp;</div>
            </div>

            @while ($project = $projects->next())
                <div class="flex justify-between">
                    <div class="w-2/4">{{ $project->projectTitle }}</div>
                    <div class="w-1/4 text-left">{{ round($project->seconds / 3600, 2) }}</div>
                    <div class="w-1/4 text-left text-gray-800 hover:text-gray-300">
                        ${{ (int) ($project->getHours() * $hourlyRate) }}
                    </div>
                </div>
            @endwhile

            <div class="flex justify-between mt-4">
                <div class="w-2/4">&nbsp;</div>
                <div class="w-1/4 text-left">{{ $totalHours }}</div>
                <div class="w-1/4 text-left text-gray-800 hover:text-gray-300">
                    ${{ (int) ($totalHours * $hourlyRate) }}
                </div>
            </div>
        @endif

        <div class="mt-16">
            <div>{{ $dayOfMonth->format('F, Y') }}</div>
            <div><span class="hover:border-b cursor-pointer">&lt;</span></div>
            <div><span class="hover:border-b cursor-pointer">&gt;</span></div>
        </div>
    </div>
</div>
