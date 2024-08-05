<script setup>
const pages = {
    today: 'Today',
    month: 'Month',
    settings: 'Settings',
}

const props = defineProps({
    active: { type: String, required: true },
})
</script>

<template>
<div class="w-full absolute text-xs" style="bottom: 30px; left: 0;">
    <div class="flex justify-around">
        <div class="w-64 group text-center flex justify-between">
            <div v-for="(label, path) in pages" class="w-24">
                <a v-if="path !== props.active" :href="`/${path}`" class="text-gray-600 hover:text-gray-100">{{ label }}</a>
                <span v-else class="inline-block text-gray-400">{{ label }}</span>
            </div>
        </div>
    </div>
</div>

</template>
