<script setup>
import axios from 'axios';
import { ref, computed } from 'vue';
import Navigation from "../../components/Navigation.vue";

const props = defineProps({
    trackers: { type: Array, required: true },
    navigation: { type: Object, required: true }
})

const editingTracker = ref(null);
const message = ref('');

const getConfigHelper = (type) => {
    const helpers = {
        'mayven': '{"api_url": "https://example.com", "token": "Bearer ey..."}',
        'clockify': '{"token": "xxx", "workspace_id": "xxx", "user_id": "xxx"}',
        'everhour': '{"api_url": "https://api.everhour.com", "token": "xxx"}',
    };
    return helpers[type] || '{}';
};

const editTrackerHelper = computed(() => getConfigHelper(editingTracker.value?.type));

const startEdit = (tracker) => {
    editingTracker.value = {
        ...tracker,
        config: JSON.stringify(tracker.config, null, 2)
    };
};

const cancelEdit = () => {
    editingTracker.value = null;
};

const updateTracker = async (tracker) => {
    try {
        const config = JSON.parse(editingTracker.value.config);
        await axios.put(`/settings/trackers/${tracker.id}`, {
            title: editingTracker.value.title,
            status: editingTracker.value.status,
            config
        });
        message.value = 'Tracker updated successfully';
        editingTracker.value = null;
        window.location.reload();
    } catch (error) {
        message.value = 'Error updating tracker';
    }
};

const deleteTracker = async (tracker) => {
    if (!confirm(`Delete tracker "${tracker.title}"?`)) return;

    try {
        await axios.delete(`/settings/trackers/${tracker.id}`);
        message.value = 'Tracker deleted successfully';
        window.location.reload();
    } catch (error) {
        message.value = 'Error deleting tracker';
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
                <!-- Existing Trackers List -->
                <div v-if="trackers.length > 0" class="mb-8">
                    <div v-for="tracker in trackers" :key="tracker.id" class="mb-4 p-4 bg-gray-800 rounded">
                        <div v-if="editingTracker?.id !== tracker.id">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="text-base text-gray-200">{{ tracker.title }}</div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        Type: {{ tracker.type }} | Status: {{ tracker.status }}
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button @click="startEdit(tracker)" class="px-3 py-1 text-xs bg-gray-700 hover:bg-gray-600 text-gray-300 rounded">Edit</button>
                                    <button @click="deleteTracker(tracker)" class="px-3 py-1 text-xs bg-red-900 hover:bg-red-800 text-gray-300 rounded">Delete</button>
                                </div>
                            </div>
                        </div>
                        <div v-else class="space-y-3">
                            <input v-model="editingTracker.title" placeholder="Title" class="w-full px-3 py-2 bg-gray-700 text-gray-200 focus:outline-none placeholder-gray-500 text-sm rounded" />

                            <select v-model="editingTracker.status" class="w-full px-3 py-2 bg-gray-700 text-gray-200 outline-none text-sm rounded">
                                <option v-for="status in trackerStatuses" :key="status" :value="status">{{ status }}</option>
                            </select>

                            <div>
                                <textarea v-model="editingTracker.config" placeholder='{"key": "value"}' rows="4" class="w-full px-3 py-2 bg-gray-700 text-gray-200 focus:outline-none placeholder-gray-500 text-xs font-mono rounded"></textarea>
                                <div v-if="editingTracker.type" class="mt-1 text-xs text-gray-500 font-mono">
                                    Expected format: {{ editTrackerHelper }}
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <button @click="updateTracker(tracker)" class="px-4 py-2 text-xs bg-green-700 hover:bg-green-600 text-gray-200 rounded">Save</button>
                                <button @click="cancelEdit" class="px-4 py-2 text-xs bg-gray-700 hover:bg-gray-600 text-gray-300 rounded">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Create New Tracker -->
                <div class="mb-4">
                    <a :href="`${props.navigation.thisLink}/trackers/create`" class="px-4 py-2 text-xs bg-gray-700 hover:bg-gray-600 text-gray-300 rounded inline-block">
                        + Add New Tracker
                    </a>
                </div>

                <div v-if="message" class="mt-6 text-center text-sm text-gray-400">
                    {{ message }}
                    <span @click="resetMessage" class="px-2 py-1 font-mono text-gray-400 hover:text-gray-200 cursor-pointer">X</span>
                </div>
            </div>
        </div>

        <Navigation active="settings" />
    </div>
</template>
