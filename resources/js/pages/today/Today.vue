<script setup>
import { hoursToString } from "../../helpers.js"

const props = defineProps({
    runningHours: { type: Number, required: true },
    todayPercent: { type: Number, required: true },
    todayHours: { type: Number, required: true },
})

</script>

<template>
<div>
    <div class="relative text-gray-600">
        Today
        <div v-if="props.runningHours" class="absolute bg-red-600 rounded-full" style="width: 10px; height: 10px; left: -45px; top: 12px;"></div>
        <div v-if="props.runningHours"
             class="absolute text-sm px-4 py-2 font-bold text-gray-700 hover:text-gray-200 cursor-none"
             style="left: -135px; top: 0px;">{{ hoursToString(props.runningHours) }}</div>
    </div>

    <div class="mt-4 group">
        <span class="group-hover:hidden">{{ props.todayPercent }}%</span>
        <span class="text-gray-800 hidden group-hover:inline-block group-hover:text-gray-200">
                {{ hoursToString(props.todayHours) }}
            </span>
    </div>
</div>
</template>
