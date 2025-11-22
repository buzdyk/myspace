<script setup>
import axios from 'axios';
import { ref } from 'vue';
import SettingsLayout from "../../layouts/SettingsLayout.vue";

const props = defineProps({
    trackerTypes: { type: Array, required: true },
    trackerStatuses: { type: Array, required: true },
    navigation: { type: Object, required: true }
})

const message = ref('');

const newTracker = ref({
    title: '',
    type: '',
    status: 'disconnected',
    config: {}
});

const createTracker = async () => {
    try {
        await axios.post('/settings/trackers', newTracker.value);
        window.location.href = '/settings/trackers';
    } catch (error) {
        message.value = 'Error creating tracker: ' + (error.response?.data?.message || 'Invalid data');
    }
};

const resetMessage = () => {
    message.value = '';
};
</script>

<template>
    <SettingsLayout :navigation="props.navigation" current-tab="trackers">
        <div class="p-4 bg-gray-800 rounded space-y-3">
            <h3 class="text-base mb-3 text-gray-300">Create New Tracker</h3>

            <input v-model="newTracker.title" placeholder="Tracker Title" class="w-full px-3 py-2 bg-gray-700 text-gray-200 focus:outline-none placeholder-gray-500 text-sm rounded" />

            <select v-model="newTracker.type" class="w-full px-3 py-2 bg-gray-700 text-gray-200 outline-none text-sm rounded">
                <option value="" disabled>Select Type</option>
                <option v-for="type in trackerTypes" :key="type" :value="type">{{ type }}</option>
            </select>

            <select v-model="newTracker.status" class="w-full px-3 py-2 bg-gray-700 text-gray-200 outline-none text-sm rounded">
                <option v-for="status in trackerStatuses" :key="status" :value="status">{{ status }}</option>
            </select>

            <!-- Mayven Config -->
            <div v-if="newTracker.type === 'mayven'" class="space-y-3">
                <input v-model="newTracker.config.api_url" placeholder="API URL" class="w-full px-3 py-2 bg-gray-700 text-gray-200 focus:outline-none placeholder-gray-500 text-sm rounded" />
                <input v-model="newTracker.config.token" placeholder="API Token" class="w-full px-3 py-2 bg-gray-700 text-gray-200 focus:outline-none placeholder-gray-500 text-sm rounded" />
            </div>

            <!-- Everhour Config -->
            <div v-if="newTracker.type === 'everhour'" class="space-y-3">
                <input v-model="newTracker.config.api_url" placeholder="API URL" class="w-full px-3 py-2 bg-gray-700 text-gray-200 focus:outline-none placeholder-gray-500 text-sm rounded" />
                <input v-model="newTracker.config.token" placeholder="API Token" class="w-full px-3 py-2 bg-gray-700 text-gray-200 focus:outline-none placeholder-gray-500 text-sm rounded" />
            </div>

            <!-- Clockify Config -->
            <div v-if="newTracker.type === 'clockify'" class="space-y-3">
                <input v-model="newTracker.config.token" placeholder="API Token" class="w-full px-3 py-2 bg-gray-700 text-gray-200 focus:outline-none placeholder-gray-500 text-sm rounded" />
                <input v-model="newTracker.config.workspace_id" placeholder="Workspace ID" class="w-full px-3 py-2 bg-gray-700 text-gray-200 focus:outline-none placeholder-gray-500 text-sm rounded" />
                <input v-model="newTracker.config.user_id" placeholder="User ID" class="w-full px-3 py-2 bg-gray-700 text-gray-200 focus:outline-none placeholder-gray-500 text-sm rounded" />
            </div>

            <div>
                <button @click="createTracker" class="px-4 py-2 text-xs bg-green-700 hover:bg-green-600 text-gray-200 rounded">Create Tracker</button>
            </div>
        </div>

        <div v-if="message" class="mt-6 text-center text-sm text-red-400">
            {{ message }}
            <span @click="resetMessage" class="px-2 py-1 font-mono text-gray-400 hover:text-gray-200 cursor-pointer">X</span>
        </div>
    </SettingsLayout>
</template>
