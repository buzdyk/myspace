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
    isToday: { type: Boolean, required: true },
    readableDate: { type: String, required: true },
})

setTimeout(() => router.visit(window.location.pathname, {
    except: [],
}), 120000)
</script>

<template>
<div class="h-screen flex justify-around items-center font-mono text-xl selection:bg-red-700 selection:text-white">
    <div>
        <div class="flex justify-between w-96">
            <Today
                :isToday="props.isToday"
                :runningHours="props.runningHours"
                :todayHours="props.todayHours"
                :todayPercent="props.todayPercent"
            />
            <Month :monthPercent="props.monthPercent" :monthHours="props.monthHours" />
            <Pace :pace="props.pace" />
        </div>

<!--        hours by project feature -->
<!--        <div class="text-sm mt-10 text-gray-600">-->
<!--            <div class="flex justify-between hover:text-gray-200">-->
<!--                <div>Project 1</div>-->
<!--                <div></div>-->
<!--                <div>1:28</div>-->
<!--            </div>-->
<!--        </div>-->

<!--        ux rework. progress bar, can be stacked eg today: tracked + active + remaining -->
<!--        <div class="mt-8 flex justify-start">&#45;&#45;}}-->
<!--            <div style="width: {{ $passed }}%; height: 3px;" class="bg-gray-600">&nbsp;</div>-->
<!--            <div style="width: {{ 100 - $passed }}%;  height: 3px;" class="bg-gray-700">&nbsp;</div>-->
<!--         </div>-->
    </div>

    <div class="absolute w-96" style="bottom: 32px;">

        <div class="mt-4 text-sm flex justify-around">
            <div class="relative flex justify-between items-center text-gray-500">

                <a :href="props.nav.monthLink" class="block">
                    {{ props.nav.month }}&nbsp;
                </a> {{ props.nav.day }} {{ props.nav.year }}

                <a :href="props.nav.prevLink" class="ml-3 text-gray-600 hover:text-gray-200">&lt;</a>
                <a :href="props.nav.nextLink" class="ml-1 text-gray-600 hover:text-gray-200">&gt;</a>
            </div>
        </div>

        <div class="mt-4 flex justify-around items-center">
            <Navigation :active="isToday ? 'today' : null" />
        </div>
    </div>
</div>
</template>
