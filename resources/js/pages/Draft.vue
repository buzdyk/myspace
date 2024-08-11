<script setup>
import Navigation from './../components/Navigation.vue'
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

import { hoursToString, formatMoney } from './../helpers.js'

const daysOfWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

const props = defineProps({
    days: { type: Array, required: true },
    prevMonthLink: { type: String, required: true },
    nextMonthLink: { type: String, required: true },
})

const days = props.days

const dailyGoal = computed(() => usePage().props.dailyGoal),
    hourlyRate = computed(() => usePage().props.hourlyRate)

// const paceClass = computed(() => {
//     return ''
// })
</script>

<template>
    <div class="h-screen w-full flex justify-center items-center font-mono text-2xl selection:bg-red-700 selection:text-white">
        <div class="grid grid-cols-7 gap-y-4 gap-x-6 text-center">
            <div v-for="(day, index) in daysOfWeek" :key="index" class="text-left font-bold text-gray-400 text-sm">
                {{ day }}
            </div>

            <div class="col-span-7 border-b border-b-gray-700"></div>

            <div v-for="day in props.days" class="group relative mt-4">
                <div v-if="day" class="text-gray-500 text-left text-xs">{{ day.date }}</div>

                <div v-if="day.hours" class="flex w-16 cursor-none justify-start mt-2">
                    <div>
                        <div class="group-hover:hidden text-sm text-left">{{ hoursToString(day.hours) }}</div>
                        <div class="group-hover:block hidden text-sm test-left">{{ formatMoney(day.hours * hourlyRate) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <Navigation active="month">
            <div class="mb-2">
                <div class="flex justify-start text-sm">
                    <span class="block text-gray-300">July 2024</span>
                    <a :href="props.prevMonthLink" class="ml-1 px-1 text-gray-600 hover:text-gray-200">&lt;</a>
                    <a :href="props.nextMonthLink" class="px-1 text-gray-600 hover:text-gray-200">&gt;</a>
                </div>
                <span class="block mt-2 text-xs text-gray-400">Calendar</span>
                <a href="#" class="text-xs block text-gray-600 hover:text-gray-100">Projects</a>
            </div>
        </Navigation>
    </div>
</template>


