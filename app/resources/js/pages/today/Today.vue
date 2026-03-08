<script setup>
import { hoursToString } from "../../helpers.js"

const props = defineProps({
    runningHours: { type: Number, required: true },
    todayPercent: { type: Number, required: true },
    todayHours: { type: Number, required: true },
    isToday: { type: Boolean, required: true },
})

</script>

<template>
<div>
    <div class="relative text-gray-600">
        Goal
        <div v-if="props.runningHours"
             class="absolute rounded-full"
             style="width: 10px; height: 10px; left: -45px; top: 12px;"
             :class="{ 'bg-red-600': props.isToday, 'bg-red-900': !props.isToday }"
        ></div>
        <div v-if="props.runningHours"
             class="absolute text-sm px-4 py-2 font-bold text-gray-700 hover:text-gray-200 cursor-none"
             style="left: -135px; top: 0;"
        >{{ hoursToString(props.runningHours) }}</div>
    </div>

    <div class="mt-4 group w-12">
        <span class="group-hover:hidden">{{ props.todayPercent }}%</span>
        <span class="text-gray-800 hidden group-hover:inline-block group-hover:text-gray-200">
            {{ hoursToString(props.todayHours) }}
        </span>
    </div>
</div>
</template>
