<div class="h-screen flex items-center justify-center font-mono">
    <div class="w-2/3 text-2xl selection:bg-red-700 selection:text-white">
        <div class="flex justify-between mb-4 text-gray-200 group">
            <div class="relative">
                Soho club membership, 1y
                <div class="absolute" style="top: 0; margin-left: -80px;">
                    <div class="flex justify-end text-gray-800 hover:text-gray-400 ">
                        <span class="cursor-pointer hover:text-green-500">✓</span>
                        <span class="ml-6 cursor-pointer hover:text-red-500">x</span>
                    </div>
                </div>
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
    </div>

    @include('menu', ['active' => 'wishlist'])
</div>
