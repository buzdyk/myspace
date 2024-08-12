<script setup>
import Navigation from './../components/Navigation.vue'
import { router } from '@inertiajs/vue3'

import Month from './today/Month.vue'
import Pace from './today/Pace.vue'
import Today from './today/Today.vue'

const props = defineProps({
    runningHours: { type: Number, required: true },
    todayPercent: { type: Number, required: true },
    monthPercent: { type: Number, required: true },
    todayHours: { type: Number, required: true },
    monthHours: { type: Number, required: true },
    pace: { type: Number, required: true },
    nav: { type: Object, required: true },
})

// setTimeout(() => router.visit(window.location.pathname, {
//     except: [],
// }), 15000)
</script>

<template>
<div class="h-screen flex justify-around items-center font-mono text-xl selection:bg-red-700 selection:text-white">
    <div class="flex justify-between w-96">
        <Today :runningHours="props.runningHours" :todayHours="props.todayHours" :todayPercent="props.todayPercent" />
        <Month :monthPercent="props.monthPercent" :monthHours="props.monthHours" />
        <Pace :pace="props.pace" />
    </div>

    <!--            progress bar-->
    <!--            <div class="mt-8 flex justify-start">&#45;&#45;}}-->
    <!--                <div style="width: {{ $passed }}%; height: 3px;" class="bg-gray-600">&nbsp;</div>-->
    <!--                <div style="width: {{ 100 - $passed }}%;  height: 3px;" class="bg-gray-700">&nbsp;</div>-->
    <!--            </div>-->

    <div class="absolute w-96" style="bottom: 32px;">
        <div class="mt-16 text-sm flex justify-around">
            <div class="mb-4 flex justify-between">
                <span class="block text-gray-500">{{ props.nav.caption }}</span>

                <a :href="props.nav.prevLink" class="ml-3 text-gray-600 hover:text-gray-200">&lt;</a>
                <a :href="props.nav.nextLink" class="ml-1 text-gray-600 hover:text-gray-200">&gt;</a>
            </div>
        </div>

        <div class="flex justify-around items-center">
            <Navigation active="today" />
        </div>
    </div>
</div>
</template>
