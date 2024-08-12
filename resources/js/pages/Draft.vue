<script setup>
import Navigation from './../components/Navigation.vue'
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

import { hoursToString, formatMoney } from './../helpers.js'

const daysOfWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

const props = defineProps({
    days: { type: Array, required: true },
    links: { type: Array, required: true },
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
    <div>
        <div class="grid grid-cols-7 gap-y-5 gap-x-3 text-center">
            <div v-for="(day, index) in daysOfWeek" :key="index" class="text-left font-bold text-gray-400 text-sm">
                {{ day }}
            </div>

            <div class="col-span-7 border-b border-b-gray-700"></div>

            <div v-for="day in props.days" class="group relative">
                <div v-if="day" class="text-gray-500 text-left text-xs">{{ day.date }}</div>

                <div v-if="day.hours" class="flex w-16 cursor-none justify-start mt-2 text-sm">
                    <div class="group-hover:hidden">{{ hoursToString(day.hours) }}</div>
                    <div class="group-hover:block hidden">{{ formatMoney(day.hours * hourlyRate) }}</div>
                </div>

                <div v-if="!day || !day.hours">&nbsp;</div>
            </div>
        </div>

    </div>
    <div class="absolute w-full" style="bottom: 32px;">
        <div class="mb-4 text-sm flex justify-around">
            <div class="flex justify-around">
                <span class="block text-gray-400">July 2024</span>

                <a :href="`${props.links.prevMonth}/calendar`" class="ml-3 text-gray-600 hover:text-gray-200">&lt;</a>
                <a :href="`${props.links.nextMonth}/calendar`" class="ml-1 text-gray-600 hover:text-gray-200">&gt;</a>
            </div>
        </div>

        <div class="flex justify-around items-center">
            <Navigation active="month" />
        </div>
    </div>
</div>
</template>

<style scoped>
.break {
    flex-basis: 100%;
    height: 0;
}
</style>

