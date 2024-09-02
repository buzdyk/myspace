<script setup>
import Navigation from "../components/Navigation.vue"
import EmptyPlaceholder from './projects/EmptyPlaceholder.vue'
import Overview from './projects/Overview.vue'

const props = defineProps({
    projects: { type: Array, required: true },
    monthHours: { type: Number, required: true },
    dayOfMonth: { type: String, required: true },
    weekdays: { type: Number, required: true },
    weekends: { type: Number, required: true },
    links: { type: Array, required: true },
})
</script>

<template>
<div class="h-screen flex justify-center items-center font-mono">
    <div class="text-lg selection:bg-red-700 selection:text-white">
        <div class="flex justify-start text-xs -ml-1">
            <a :href="`${props.links.thisLink}/projects`" class="block pl-1 pr-5 py-1 mr-4 bg-gray-700 text-center text-gray-400">Projects</a>
            <a :href="`${props.links.thisLink}/calendar`" class="block pl-1 pr-5 py-1 ml-4 hover:bg-gray-700 text-center text-gray-400">Calendar</a>
        </div>

        <div class="mt-10 mb-20">
            <Overview v-if="monthHours" :projects="props.projects" :monthHours="props.monthHours" />
            <EmptyPlaceholder v-else />
        </div>
    </div>

    <div class="absolute w-full" style="bottom: 40px;">
        <div class="mb-6 text-base flex justify-around">
            <div class="flex justify-around">
                <span class="block text-gray-400">{{ props.links.caption }}</span>

                <a :href="`${props.links.prevLink}/projects`" class="ml-3 text-gray-600 hover:text-gray-200">&lt;</a>
                <a :href="`${props.links.nextLink}/projects`" class="ml-1 text-gray-600 hover:text-gray-200">&gt;</a>
            </div>
        </div>

        <div class="flex justify-around items-center">
            <Navigation active="month" />
        </div>
    </div>
</div>
</template>
