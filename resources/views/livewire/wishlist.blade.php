<div class="h-screen flex items-center justify-center font-mono">
    <div class="w-2/3 text-2xl selection:bg-red-700 selection:text-white">
{{--            <h1>Time not found for the month</h1>--}}

        <div class="flex justify-between mb-4 text-gray-600">
            <div class="relative">
                What
                <span class="absolute hover:text-gray-100 cursor-pointer" style="left:-50px;">+</span>
            </div>
            <div class="w-2/5 text-right">How much</div>
        </div>

        <div class="flex justify-between mb-4 text-gray-600">
            <div class="relative">
                <input type="text" class="w-full bg-gray-800 focus:outline-none focus:border-gray-100 focus:text-gray-100 border-b border-gray-600 text-gray-600">
                <span class="absolute hover:text-gray-100 cursor-pointer" style="left:-50px;">+</span>
            </div>
            <div class="w-2/5 text-right">How much</div>
        </div>

        <div class="flex justify-between mb-4 text-gray-200">
            <div class="relative">
                Soho club membership, 1y
                <span class="absolute text-gray-600 hover:text-gray-100 cursor-pointer" style="left:-50px;">-</span>
            </div>
            <div class="text-right">$2,000</div>
        </div>

        <div class="flex justify-between mb-4 text-gray-200">
            <div>Motorcycle</div>
            <div class="text-right">$4,700</div>
        </div>

        <div class="flex justify-between mb-4 text-gray-200">
            <div>10k in savings</div>
            <div class="text-right">$10,000</div>
        </div>

{{--        <div class="flex justify-between mb-4 text-gray-200">--}}
{{--            <div>--}}
{{--            </div>--}}
{{--            <div class="text-right">--}}
{{--                <input type="number" class="text-right w-32 bg-gray-800 focus:outline-none border-b border-gray-600 text-gray-600 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">--}}
{{--            </div>--}}
{{--        </div>--}}


        {{--        10k in savings --}}


        {{--            <div class="flex justify-between mt-4">--}}
{{--                <div class="w-2/4">&nbsp;</div>--}}
{{--                <div class="w-1/4 text-left">{{ $totalHours }}</div>--}}
{{--                <div class="w-1/4 text-left">--}}
{{--                    ${{ number_format($totalHours * $hourlyRate) }}--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="mt-16">
{{--                {{ $dayOfMonth->format('F, Y') }}--}}
{{--                <span wire:click="sub" class="text-gray-600 hover:text-gray-100 hover:border-b cursor-pointer">&lt;</span>--}}
{{--                <span wire:click="add" class="text-gray-600 hover:text-gray-100 hover:border-b cursor-pointer">&gt;</span>--}}
            </div>
    </div>

    <a href="/" class="absolute text-gray-600 hover:text-gray-100 hover:border-b hover:cursor-pointer" style="bottom: 24px; right: 48px;">Goals</a>
</div>
