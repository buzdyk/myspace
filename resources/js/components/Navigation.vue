<script setup>
const pages = {
    today: 'Today',
    month: 'Month',
    settings: 'Settings',
}

const props = defineProps({
    active: { type: String, required: true },
})

const last = 'settings'
</script>

<template>
<div class="w-full absolute text-xs" style="bottom: 40px; left: 0;">
    <div class="flex justify-around">
        <div class="flex justify-between">
            <template v-for="(label, path) in pages">
                <span v-if="path === props.active" class="inline-block text-gray-400" :class="{'mr-12': path !== last}">{{ label }}</span>
                <a v-else :href="`/${path}`" class="inline-block text-gray-600 hover:text-gray-100 hover:border-b"  :class="{'mr-12': path !== last}">{{ label }}</a>
            </template>
        </div>
    </div>
</div>

</template>
