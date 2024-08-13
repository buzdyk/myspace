<script setup>
const pages = [
    { path: 'today', caption: 'Today' },
    { path: 'month', caption: 'Month' },
    // { path: 'settings', caption: 'Settings' },
]

const props = defineProps({
    active: { type: String, required: true },
})

console.log(props.active)
</script>

<template>
<div>
    <slot></slot>
    <div class="flex justify-start">
        <div v-for="(page, index) in pages" class="text-xs" :class="{'mr-6': index !== pages.length - 1,}">
            <a :href="`/${page.path}`" class="hover:text-gray-100" :class="{ 'text-gray-200' : page.path === props.active, 'text-gray-600': page.path !== props.active }">{{ page.caption }}</a>
        </div>
    </div>
</div>
</template>
