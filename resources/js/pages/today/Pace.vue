<script setup>
import { hoursToString } from '../../helpers.js'
import { computed } from 'vue'
import {usePage} from "@inertiajs/vue3";

const props = defineProps({
    pace: { type: Number, required: true }
})

const dailyGoal = computed(() => usePage().props.dailyGoal)

const paceClass = computed(() => {
    if (props.pace < -dailyGoal.value) return 'text-red-600'
    if (props.pace > 0) return 'text-green-600'
    return ''
})
</script>

<template>
<div>
    <div class="text-gray-600">Pace</div>
    <div class="mt-4" :class="paceClass">
        {{ hoursToString(Math.abs(props.pace)) }}
    </div>
</div>
</template>
