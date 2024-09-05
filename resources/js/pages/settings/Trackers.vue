<script setup>
import Navigation from "../../components/Navigation.vue";

const props = defineProps({
    navigation: { type: Object, required: true }
})
</script>

<template>
    <div class="h-screen flex items-center justify-center font-mono">
        <div class="relative w-1/2 text-xl selection:bg-red-700 selection:text-white">
            <div class="text-lg selection:bg-red-700 selection:text-white">
                <div class="flex justify-start text-xs -ml-1">
                    <a :href="`${props.navigation.thisLink}/general`" class="block pl-1 pr-5 py-1 mr-4 hover:bg-gray-700 text-center text-gray-400">General</a>
                    <a :href="`${props.navigation.thisLink}/trackers`" class="block pl-1 pr-5 py-1 ml-4 bg-gray-700 text-center text-gray-400">Trackers</a>
                </div>
            </div>

            <form @submit.prevent="saveSettings" class="mt-10">
<!--                <div class="flex justify-between group">-->
<!--                    <label for="hourlyRate" class="block">Hourly Rate</label>-->
<!--                    <div class="flex-grow border-b-dots  ml-3 mr-1 mb-1"></div>-->
<!--                    <input v-model="hourlyRate" placeholder="xx" type="number" step="0.01" class="block w-12 bg-transparent text-right text-gray-200 focus:outline-none no-number-controls placeholder-gray-600" />-->
<!--                    <div class="w-8 ml-4 text-sm text-gray-400" style="margin-top:7px;">usd</div>-->
<!--                </div>-->

                <div class="mt-4 flex justify-between">
                    <label for="dailyGoal" class="block">Tracker</label>
                    <select name="" id="" class="w-64 px-3 py-1 bg-gray-700 outline-none">
                        <option></option>
                        <option value="everhour">Everhour</option>
                        <option value="clockify">Clockify</option>
                        <option value="everhour">Mayven</option>
                    </select>
                </div>

                <div class="mt-4 flex justify-between">
                    <label for="monthlyGoal" class="block">Token</label>
                    <input type="text" class="block w-64 px-3 py-1 bg-gray-700 focus:outline-none placeholder-gray-600" placeholder="Bearer ey..." />
                </div>

                <div class="mt-4 flex justify-between">
                    <label for="monthlyGoal" class="block">Token</label>
                    <input type="text" class="block w-64 px-3 py-1 bg-gray-700 focus:outline-none placeholder-gray-600" placeholder="xxxx-xxxx-xxxxxx-xxxxxx-xxxxxxxx" />
                </div>

                <div class="mt-20 flex justify-around">
                    <button type="submit" class="block w-1/2 bg-transparent text-gray-600 hover:text-gray-200 font-bold py-2 px-4 rounded border border-gray-600 hover:border hover:border-gray-500">Save</button>

                </div>

                <div v-if="message" class="mt-6 text-center text-sm text-gray-400">
                    {{ message }}
                    <span
                        @click="resetMessage"
                        class="px-2 py-1 font-mono text-gray-400 hover:text-gray-200 cursor-pointer"
                    >X</span>
                </div>
            </form>
        </div>

        <Navigation active="settings" />
    </div>
</template>
