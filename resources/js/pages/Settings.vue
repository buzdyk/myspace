<script setup>
import { router } from '@inertiajs/vue3'
import Navigation from './../components/Navigation.vue'

const props = defineProps({
    hourlyRate: { type: Number, required: true },
    dailyGoal: { type: Number, required: true },
    monthlyGoal: { type: Number, required: true },
})

let hourlyRate = props.hourlyRate,
    dailyGoal = props.dailyGoal,
    monthlyGoal = props.monthlyGoal

const saveSettings = async () => {
    try {
        await router.post('/api/settings', { hourlyRate, dailyGoal, monthlyGoal })
        alert('Settings saved successfully!')
    } catch (error) {
        alert('Failed to save settings.')
    }
}
</script>

<template>
<div class="h-screen flex items-center justify-center font-mono">
    <div class="w-1/2 text-xl selection:bg-red-700 selection:text-white">
        <form @submit.prevent="saveSettings" >
            <div class="flex justify-between group">
                <label for="hourlyRate" class="block">Hourly Rate</label>
                <div class="flex-grow border-b-dots mx-3 mb-1"></div>
                <input v-model="hourlyRate" type="number" step="0.01" class="block w-12 bg-transparent text-right text-gray-200 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"/>
                <div class="w-8 ml-4 text-sm mt-2 text-gray-400">usd</div>
            </div>

            <div class="mt-4 flex justify-between">
                <label for="dailyGoal" class="block">Daily Goal</label>
                <div class="flex-grow border-b-dots mx-3 mb-1"></div>
                <input v-model="dailyGoal" type="number" step="0.01" class="block w-12 bg-transparent text-right text-gray-200 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"/>
                <div class="ml-4 w-8 text-sm mt-2 text-gray-400">hours</div>
            </div>

            <div class="mt-4 flex justify-between">
                <label for="monthlyGoal" class="block">Monthly Goal</label>
                <div class="flex-grow border-b-dots mx-3 mb-1"></div>
                <input  v-model="monthlyGoal" type="number" step="0.01" class="block w-12 bg-transparent text-right focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"/>
                <div class="w-8 ml-4 text-sm mt-2 text-gray-400">hours</div>
            </div>

            <div class="flex justify-around">
                <button type="submit" class="block mt-12 w-1/2 bg-transparent text-gray-600 hover:text-gray-200 font-bold py-2 px-4 rounded border border-gray-600 hover:border hover:border-gray-500">Save</button>
            </div>
        </form>
    </div>

    <Navigation active="settings" />
</div>
</template>

<style>
.border-b-dots {
    background-image: linear-gradient(to right, #757575 23%, rgba(255,255,255,0) 0%);
    background-position: bottom;
    background-size: 7px 1px;
    background-repeat: repeat-x;
}
</style>
