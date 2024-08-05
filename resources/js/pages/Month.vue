<script setup>
import Navigation from "../components/Navigation.vue"
import EmptyPlaceholder from './month/EmptyPlaceholder.vue'
import Overview from './month/Overview.vue'
import DailyHours from './month/DailyHours.vue'

const props = defineProps({
    projects: { type: Array, required: true },
    monthHours: { type: Number, required: true },
    dailyHours: { type: Array, required: true },
    dayOfMonth: { type: String, required: true },
    weekdays: { type: Number, required: true },
    weekends: { type: Number, required: true },
    prevMonthLink: { type: String, required: true },
    nextMonthLink: { type: String, required: true },
})
</script>

<template>
<div class="h-screen flex items-center justify-center font-mono">
    <div class="w-1/2 text-2xl selection:bg-red-700 selection:text-white">
        <Overview v-if="monthHours" :projects="props.projects" :monthHours="props.monthHours" />
        <EmptyPlaceholder v-else />

        <div class="mt-16">
            {{ props.dayOfMonth }}

            <a :href="props.prevMonthLink" class="ml-4 text-gray-600 hover:text-gray-100 hover:border-b cursor-pointer">&lt;</a>
            <a :href="props.nextMonthLink" class="ml-4 text-gray-600 hover:text-gray-100 hover:border-b cursor-pointer">&gt;</a>
        </div>
        <div class="mt-6 text-sm inline-block text-gray-600 hover:text-gray-200">
            {{ props.weekdays }} weekdays <br> {{ props.weekends }} weekends
        </div>
    </div>

    <div v-if="monthHours" class="absolute h-screen flex items-center pr-36 text-xs text-gray-600 hover:text-white" style="left:48px">
        <DailyHours :daily-hours="props.dailyHours" />
    </div>

    <Navigation active="month" />
</div>
</template>
