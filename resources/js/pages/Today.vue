<script setup>
import Navigation from './../components/Navigation.vue'
import { router, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const hoursToString = (number) =>
    Math.floor(number) + ':' +
    Math.round((number - Math.floor(number)) * 60).toString().padStart(2, '0')

const props = defineProps({
    runningHours: { type: Number, required: true },
    todayPercent: { type: Number, required: true },
    monthPercent: { type: Number, required: true },
    todayHours: { type: Number, required: true },
    monthHours: { type: Number, required: true },
    pace: { type: Number, required: true },
})

const dailyGoal = computed(() => usePage().props.dailyGoal)

const paceClass = computed(() => {
    if (props.pace < -dailyGoal.value) return 'text-red-600'
    if (props.pace > 0) return 'text-green-600'
    return ''
})

// setTimeout(() => router.visit(window.location.pathname, {
//     except: ['users'],
// }), 15000)
</script>

<template>
<div class="h-screen flex justify-between items-center font-mono text-2xl selection:bg-red-700 selection:text-white">
    <div>
        <a href="#" class="block ml-12 px-12 py-4 text-gray-600 hover:text-gray-200">&lt;</a>
    </div>

    <div class="flex justify-between w-80">
        <div>
            <div class="relative text-gray-600">
                Today
                <div v-if="props.runningHours" class="absolute bg-red-600 rounded-full" style="width: 10px; height: 10px; left: -45px; top: 12px;"></div>
                <div v-if="props.runningHours"
                     class="absolute text-sm px-4 py-2 font-bold text-gray-700 hover:text-gray-200 cursor-none"
                     style="left: -135px; top: 0px;">{{ hoursToString(props.runningHours) }}</div>
            </div>

            <div class="mt-4 group">
                <span class="group-hover:hidden">{{ props.todayPercent }}%</span>
                <span class="text-gray-800 hidden group-hover:inline-block group-hover:text-gray-200">
                    {{ hoursToString(props.todayHours) }}
                </span>
            </div>
        </div>

        <div>
            <div class="text-gray-600">Month</div>
            <div class="mt-4 group">
                <span class="group-hover:hidden">{{ props.monthPercent }}%</span>
                <span class="text-gray-800 hidden group-hover:inline-block group-hover:text-gray-200">
                    {{ hoursToString(props.monthHours) }}
                </span>
            </div>
        </div>

        <div>
            <div class="text-gray-600">Pace</div>
            <div class="mt-4" :class="paceClass">
                {{ hoursToString(Math.abs(props.pace)) }}
            </div>
        </div>
    </div>

    <div>
        <a href="#" class="block px-12 py-4 mr-12 text-gray-600 hover:text-gray-200">&gt;</a>
    </div>

<!--            progress bar-->
<!--            <div class="mt-8 flex justify-start">&#45;&#45;}}-->
<!--                <div style="width: {{ $passed }}%; height: 3px;" class="bg-gray-600">&nbsp;</div>-->
<!--                <div style="width: {{ 100 - $passed }}%;  height: 3px;" class="bg-gray-700">&nbsp;</div>-->
<!--            </div>-->


    <Navigation active="today" />
</div>
</template>
