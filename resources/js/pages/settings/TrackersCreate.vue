<script setup>
import axios from 'axios';
import { ref, computed } from 'vue';
import Navigation from "../../components/Navigation.vue";

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
    config: '{}'
});

const getConfigHelper = (type) => {
    const helpers = {
        'mayven': '{"api_url": "https://example.com", "token": "Bearer ey..."}',
        'clockify': '{"token": "xxx", "workspace_id": "xxx", "user_id": "xxx"}',
        'everhour': '{"api_url": "https://api.everhour.com", "token": "xxx"}',
    };
    return helpers[type] || '{}';
};

const configHelper = computed(() => getConfigHelper(newTracker.value.type));

const createTracker = async () => {
    try {
        const config = JSON.parse(newTracker.value.config);
        await axios.post('/settings/trackers', {
            ...newTracker.value,
            config
        });
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
    <div class="h-screen flex items-center justify-center font-mono">
        <div class="relative w-3/4 text-sm selection:bg-red-700 selection:text-white">
            <div class="text-lg selection:bg-red-700 selection:text-white">
                <div class="flex justify-start text-xs -ml-1">
                    <a :href="`${props.navigation.thisLink}/general`" class="block pl-1 pr-5 py-1 mr-4 hover:bg-gray-700 text-center text-gray-400">General</a>
                    <a :href="`${props.navigation.thisLink}/trackers`" class="block pl-1 pr-5 py-1 ml-4 bg-gray-700 text-center text-gray-400">Trackers</a>
                </div>
            </div>

            <div class="mt-10">
                <div class="flex items-center gap-4 mb-6">
                    <a :href="`${props.navigation.thisLink}/trackers`" class="text-gray-400 hover:text-gray-200">← Back to Trackers</a>
                </div>

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

                    <div>
                        <textarea v-model="newTracker.config" placeholder='{"api_url": "...", "token": "..."}' rows="8" class="w-full px-3 py-2 bg-gray-700 text-gray-200 focus:outline-none placeholder-gray-500 text-xs font-mono rounded"></textarea>
                        <div v-if="newTracker.type" class="mt-1 text-xs text-gray-500 font-mono">
                            Expected format: {{ configHelper }}
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button @click="createTracker" class="px-4 py-2 text-xs bg-green-700 hover:bg-green-600 text-gray-200 rounded">Create Tracker</button>
                        <a :href="`${props.navigation.thisLink}/trackers`" class="px-4 py-2 text-xs bg-gray-700 hover:bg-gray-600 text-gray-300 rounded inline-block">Cancel</a>
                    </div>
                </div>

                <div v-if="message" class="mt-6 text-center text-sm text-red-400">
                    {{ message }}
                    <span @click="resetMessage" class="px-2 py-1 font-mono text-gray-400 hover:text-gray-200 cursor-pointer">X</span>
                </div>
            </div>
        </div>

        <Navigation active="settings" />
    </div>
</template>
