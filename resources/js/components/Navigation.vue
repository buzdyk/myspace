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
<div class="h-full absolute" style="left: 30px;top: 50%;">
    <div class="w-64 group">
        <slot></slot>
        <div v-for="(label, path) in pages" class="text-xs">
            <a v-if="path !== props.active" :href="`/${path}`" class="text-gray-600 hover:text-gray-100">{{ label }}</a>
            <span v-else class="inline-block text-gray-400">{{ label }}</span>
        </div>
    </div>
</div>

</template>
