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
    links: { type: Array, required: true },
})
</script>

<template>
<div class=" font-mono">
    <div class="h-screen flex justify-center items-center">
        <div class=" w-1/2 text-xl selection:bg-red-700 selection:text-white">
            <div>
                <Overview v-if="monthHours" :projects="props.projects" :monthHours="props.monthHours" />
                <EmptyPlaceholder v-else />

                <Navigation active="month">
                    <div class="text-xs">
                        <div class="flex justify-start">
                            <a :href="`${props.links.thisMonth}/calendar`" class="text-xs block text-gray-600 hover:text-gray-100">Calendar</a>
                            <span class="block ml-2 text-gray-400">Projects</span>
                        </div>
                        <div class="mt-1 flex justify-start">
                            <span class="block text-gray-400">July 2024</span>
                            <a :href="`${props.links.prevMonth}/projects`" class="ml-1 px-1 text-gray-600 hover:text-gray-200">&lt;</a>
                            <a :href="`${props.links.nextMonth}/projects`" class="px-1 text-gray-600 hover:text-gray-200">&gt;</a>
                        </div>
                    </div>
                </Navigation>
            </div>

    <!--        <div class="mt-6 text-sm inline-block text-gray-600 hover:text-gray-200">-->
    <!--            {{ props.weekdays }} weekdays <br> {{ props.weekends }} weekends-->
    <!--        </div>-->
        </div>
    </div>

</div>
</template>
