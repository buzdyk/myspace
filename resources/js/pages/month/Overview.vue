<script setup>
import { usePage } from '@inertiajs/vue3'
import { computed } from "vue"

const hourlyRate = computed(() => usePage().props.hourlyRate)

const props = defineProps({
    projects: { type: Array, required: true },
    monthHours: { type: Number, required: true },
})

// todo refactor to helper
const hoursToString = (number) =>
    Math.floor(number) + ':' + Math.round((number - Math.floor(number)) * 60).toString().padStart(2, '0')
</script>

<template>
<div>
    <div class="flex justify-between mb-4 text-gray-600">
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
</div>
</template>

