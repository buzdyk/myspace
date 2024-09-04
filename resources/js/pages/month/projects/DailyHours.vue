<script setup>
const props = defineProps({
    dailyHours: { type: Array, required: true },
})

// todo refactor to helper
const hoursToString = (number) =>
    Math.floor(number) + ':' + Math.round((number - Math.floor(number)) * 60).toString().padStart(2, '0')
</script>

<template>
<div class="">
    <div class="mb-4 flex justify-start text-gray-600">
        <div class="w-8">Day</div>
        <div class="w-16 ml-2 text-left">Hours</div>
    </div>
    <div v-for="dh in dailyHours" class="mb-1 flex justify-start group">
        <div class="w-8">
            {{ dh.day }}
        </div>
        <div class="w-16 ml-2">{{ dh.hours ? hoursToString(dh.hours) : null }}</div>
        <div class="w-24 text-gray-800 group-hover:text-gray-600">
            {{ dh.dow }}
        </div>
    </div>
</div>
</template>
