<script setup>
import { usePage } from '@inertiajs/vue3'
import { computed } from "vue"
import Navigation from "../components/Navigation.vue"
const hourlyRate = computed(() => usePage().props.hourlyRate)

const props = defineProps({
    projects: { type: Array, required: true },
    monthHours: { type: Number, required: true },
    dailyHours: { type: Array, required: true },
    dayOfMonth: { type: String, required: true },
    prevMonthLink: { type: String, required: true },
    nextMonthLink: { type: String, required: true },
})

const hoursToString = (number) =>
    Math.floor(number) + ':' +
    Math.round((number - Math.floor(number)) * 60).toString().padStart(2, '0')

const project = props.projects
</script>

<template>
<div class="h-screen flex items-center justify-center font-mono">
    <div class="w-1/2 text-2xl selection:bg-red-700 selection:text-white">

        <h1 v-if="projects.length === 0">
            Time not found for the month
        </h1>

        <div v-else class="flex justify-between mb-4 text-gray-600">
            <div class="w-2/4">
                <span>Project</span>
            </div>
            <div class="w-1/4 text-left">
                <span>Hours</span>
            </div>
            <div class="w-1/4">Earned</div>
        </div>

        <div v-for="project in projects" class="flex justify-between">
            <div class="w-2/4">{{ project.projectTitle }}</div>
            <div class="w-1/4 text-left">{{ hoursToString(project.hours) }}</div>
            <div class="w-1/4 text-left">
                ${{ (project.hours * hourlyRate).toFixed(0) }}
            </div>
        </div>

        <div v-if="projects.length > 0" class="flex justify-between mt-8">
            <div class="w-2/4">&nbsp;</div>
            <div class="w-1/4 text-left">{{ hoursToString(monthHours) }}</div>
            <div class="w-1/4 text-left">
                ${{ (monthHours * hourlyRate).toFixed(0) }}
            </div>
        </div>

        <div class="mt-16">
            {{ props.dayOfMonth }}

            <a :href="props.prevMonthLink" class="ml-4 text-gray-600 hover:text-gray-100 hover:border-b cursor-pointer">&lt;</a>
            <a :href="props.nextMonthLink" class="ml-4 text-gray-600 hover:text-gray-100 hover:border-b cursor-pointer">&gt;</a>
        </div>
    </div>


    <div v-if="projects.length > 0" class="absolute h-screen flex items-center pr-36 text-xs text-gray-600 hover:text-white" style="left:48px">
        <div class="">
            <div class="mb-4 flex justify-start text-gray-600">
                <div class="w-8">Day</div>
                <div class="w-16 ml-2 text-left">Hours</div>
            </div>
            <div v-for="dh in dailyHours" class="mb-1 flex justify-start group">
                <div class="w-8">
                    {{ dh.day }}
                </div>
                <div class="w-16 ml-2">{{ dh.hours }}</div>
                <div class="w-24 text-gray-800 group-hover:text-gray-600">
                    {{ dh.dow }}
                </div>
            </div>
        </div>
    </div>

    <Navigation active="month" />
</div>
</template>
