<script setup>
import Navigation from './../components/Navigation.vue'
import { router, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const hoursToString = (number) =>
    Math.floor(number) + ':' +
    Math.round((number - Math.floor(number)) * 60).toString().padStart(2, '0')

const props = defineProps({
    isActive: { type: Boolean, required: true },
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

setInterval(() => router.visit(window.location.pathname, {
    except: ['users'],
}), 15000)
</script>

<template>
<div class="h-screen flex items-center justify-center font-mono">
    <div class="text-2xl selection:bg-red-700 selection:text-white">
        <div class="flex justify-between">
            <div class="relative ml-8 w-32 text-gray-600">
                Today
                <div v-if="props.isActive" class="absolute bg-red-600 rounded-full" style="width: 10px; height: 10px; left: -30px; top: 12px;"></div>
            </div>
            <div class="ml-8 w-32 text-gray-600">Month</div>
            <div class="ml-8 w-32 text-gray-600">Pace</div>
        </div>

        <div class="mt-4 flex justify-between">
            <div class="ml-8 w-32 group">
                <span class="group-hover:hidden">{{ props.todayPercent }}%</span>
                <span class="text-gray-800 hidden group-hover:inline-block group-hover:text-gray-200">
                {{ hoursToString(props.todayHours) }}
            </span>
            </div>
            <div class="ml-8 w-32 group">
                <span class="group-hover:hidden">{{ props.monthPercent }}%</span>
                <span class="text-gray-800 hidden group-hover:inline-block group-hover:text-gray-200">
                {{ hoursToString(props.monthHours) }}
            </span>
            </div>
            <div class="w-32 ml-8" :class="paceClass">
                {{ hoursToString(Math.abs(props.pace)) }}
            </div>
        </div>

<!--            progress bar-->
<!--            <div class="mt-8 flex justify-start">&#45;&#45;}}-->
<!--                <div style="width: {{ $passed }}%; height: 3px;" class="bg-gray-600">&nbsp;</div>-->
<!--                <div style="width: {{ 100 - $passed }}%;  height: 3px;" class="bg-gray-700">&nbsp;</div>-->
<!--            </div>-->
    </div>

    <Navigation active="today" />
</div>
</template>
