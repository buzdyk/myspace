<script setup>
import Navigation from "../components/Navigation.vue"
import EmptyPlaceholder from './month/EmptyPlaceholder.vue'
import Overview from './month/Overview.vue'

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
<div class=" font-mono">
    <div class="h-screen flex justify-center items-center">
        <div class="text-lg selection:bg-red-700 selection:text-white">
            <div>
                <Overview v-if="monthHours" :projects="props.projects" :monthHours="props.monthHours" />
                <EmptyPlaceholder v-else />

                <div class="mt-16 flex justify-between items-end">
                    <Navigation active="month">
                        <div class="mb-1 text-xs flex justify-start ">
                            <span class="block text-gray-400">Projects</span>
                            <a :href="`${props.links.thisMonth}/calendar`" class="ml-2 text-xs block text-gray-600 hover:text-gray-100">Calendar</a>
                        </div>
                    </Navigation>

                    <div class="text-sm flex justify-start">
                        <span class="block text-gray-400">July 2024</span>

                        <a :href="`${props.links.prevMonth}/projects`" class="ml-3 text-gray-600 hover:text-gray-200">&lt;</a>
                        <a :href="`${props.links.nextMonth}/projects`" class="ml-1 text-gray-600 hover:text-gray-200">&gt;</a>
                    </div>
                </div>

            </div>

    <!--        <div class="mt-6 text-sm inline-block text-gray-600 hover:text-gray-200">-->
    <!--            {{ props.weekdays }} weekdays <br> {{ props.weekends }} weekends-->
    <!--        </div>-->
        </div>
    </div>

</div>
</template>
