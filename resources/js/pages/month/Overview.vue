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
        <div class="w-3/4">
            <span>Project</span>
        </div>
        <div class="text-right">
            <span>Hours</span>
        </div>
        <div class="w-32 text-right">Earned</div>
    </div>

    <div v-for="project in projects" class="flex justify-between">
        <div class="w-3/4 flex justify-between">
            {{ project.projectTitle }}
            <div class="flex-grow border-b-dots mx-3 mb-1"></div>
        </div>
        <div class="text-right">{{ hoursToString(project.hours) }}</div>
        <div class="w-32 text-right">
            ${{ (project.hours * hourlyRate).toFixed(0) }}
        </div>
    </div>

    <div v-if="projects.length > 0" class="flex justify-between mt-8">
        <div class="w-3/4">&nbsp;</div>
        <div class="text-right">{{ hoursToString(monthHours) }}</div>
        <div class="w-32 text-right">
            ${{ (monthHours * hourlyRate).toFixed(0) }}
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


