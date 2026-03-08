<script setup>
import { usePage } from '@inertiajs/vue3'
import { computed } from "vue"

const hourlyRate = computed(() => usePage().props.hourlyRate)

const props = defineProps({
    projects: { type: Array, required: true },
    monthHours: { type: Number, required: true },
    projectedIncome: { type: Number, required: true },
    projectedHours: { type: Number, required: true },
})

const hoursToString = (number) =>
    Math.floor(number) + ':' + Math.round((number - Math.floor(number)) * 60).toString().padStart(2, '0')

const formatMoney = number => {
    const options = { maximumSignificantDigits: 0, style: 'currency', currency: 'USD' }
    return `$` + Intl.NumberFormat('en-US', ).format(number)
}
</script>

<template>
<div>
    <div v-for="project in projects" v-show="project.hours" class="flex justify-between">
        <div class="w-3/4 flex justify-between">
            {{ project.projectTitle }}
            <div class="flex-grow border-b-dots mx-3 mb-1 pr-32"></div>
        </div>
        <div class="text-right">{{ hoursToString(project.hours) }}</div>
        <div class="w-32 text-right">
            {{ formatMoney((project.hours * hourlyRate).toFixed(0)) }}
        </div>
    </div>

    <div class="mt-8 flex justify-between">
        <div class="w-3/4"></div>
        <div class="text-right">{{ hoursToString(monthHours) }}</div>
        <div class="w-32 text-right">
            {{ formatMoney((monthHours * hourlyRate).toFixed(0)) }}
        </div>
    </div>

    <div class="flex justify-between text-gray-600">
        <div class="w-3/4 text-gray-600"></div>
        <div class="text-right">{{ hoursToString(projectedHours) }}</div>
        <div class="w-32 text-right">
            {{ formatMoney(projectedIncome) }}
        </div>
    </div>
</div>
</template>

<style>
.border-b-dots {
    background-image: linear-gradient(to right, #757575 23%, rgba(255,255,255,0) 0%);
    background-position: bottom;
    background-size: 7px 1px;
    background-repeat: repeat-x;
}
</style>


