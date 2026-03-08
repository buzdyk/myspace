<script setup>
import { hoursToString } from '../../helpers.js'

const props = defineProps({
    monthHours: { type: Number, required: true },
    monthPercent: { type: Number, required: true },
})
</script>

<template>
<div>
    <div class="text-gray-600">Month</div>
    <div class="mt-4 text-left group w-12">
        <span class=" group-hover:hidden">{{ props.monthPercent }}%</span>
        <span class="text-gray-800 hidden group-hover:inline-block group-hover:text-gray-200">
            {{ hoursToString(props.monthHours) }}
        </span>
    </div>
</div>
</template>
