<script setup>
const pages = {
    today: 'Today',
    'month-review': 'Month Review'
}
const active = 'today' // todo make it a prop
</script>

<template>
<div class="w-full absolute text-xs" style="bottom: 40px; left: 0;">
    <div class="flex justify-around">
        <div class="flex justify-between">
            <template v-for="(path, label) in pages">
                <span v-if="path === active" class="inline-block mr-12 text-gray-400">{{ label }}</span>
                <a v-else href="`/${path}``" class="inline-block mr-12 text-gray-600 hover:text-gray-100 hover:border-b">{{ label }}</a>
            </template>
        </div>
    </div>
</div>

</template>
