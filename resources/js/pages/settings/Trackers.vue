<script setup>
import axios from 'axios';
import { ref } from 'vue';
import Navigation from "../../components/Navigation.vue";

const props = defineProps({
    trackers: { type: Array, required: true },
    trackerTypes: { type: Array, required: true },
    trackerStatuses: { type: Array, required: true },
    navigation: { type: Object, required: true }
})

const showCreateForm = ref(false);
const editingTracker = ref(null);
const message = ref('');

const newTracker = ref({
    title: '',
    type: '',
    status: 'disconnected',
    config: '{}'
});

const createTracker = async () => {
    try {
        const config = JSON.parse(newTracker.value.config);
        await axios.post('/settings/trackers', {
            ...newTracker.value,
            config
        });
        message.value = 'Tracker created successfully';
        newTracker.value = { title: '', type: '', status: 'disconnected', config: '{}' };
        showCreateForm.value = false;
        window.location.reload();
    } catch (error) {
        message.value = 'Error creating tracker';
    }
};

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
                    <h3 class="text-base mb-4 text-gray-300">Your Trackers</h3>
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

                            <textarea v-model="editingTracker.config" placeholder='{"key": "value"}' rows="4" class="w-full px-3 py-2 bg-gray-700 text-gray-200 focus:outline-none placeholder-gray-500 text-xs font-mono rounded"></textarea>

                            <div class="flex gap-2">
                                <button @click="updateTracker(tracker)" class="px-4 py-2 text-xs bg-green-700 hover:bg-green-600 text-gray-200 rounded">Save</button>
                                <button @click="cancelEdit" class="px-4 py-2 text-xs bg-gray-700 hover:bg-gray-600 text-gray-300 rounded">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Create New Tracker -->
                <div class="mb-4">
                    <button v-if="!showCreateForm" @click="showCreateForm = true" class="px-4 py-2 text-xs bg-gray-700 hover:bg-gray-600 text-gray-300 rounded">
                        + Add New Tracker
                    </button>
                </div>

                <div v-if="showCreateForm" class="p-4 bg-gray-800 rounded space-y-3">
                    <h3 class="text-base mb-3 text-gray-300">Create New Tracker</h3>

                    <input v-model="newTracker.title" placeholder="Tracker Title" class="w-full px-3 py-2 bg-gray-700 text-gray-200 focus:outline-none placeholder-gray-500 text-sm rounded" />

                    <select v-model="newTracker.type" class="w-full px-3 py-2 bg-gray-700 text-gray-200 outline-none text-sm rounded">
                        <option value="" disabled>Select Type</option>
                        <option v-for="type in trackerTypes" :key="type" :value="type">{{ type }}</option>
                    </select>

                    <select v-model="newTracker.status" class="w-full px-3 py-2 bg-gray-700 text-gray-200 outline-none text-sm rounded">
                        <option v-for="status in trackerStatuses" :key="status" :value="status">{{ status }}</option>
                    </select>

                    <textarea v-model="newTracker.config" placeholder='{"api_url": "...", "token": "..."}' rows="6" class="w-full px-3 py-2 bg-gray-700 text-gray-200 focus:outline-none placeholder-gray-500 text-xs font-mono rounded"></textarea>

                    <div class="flex gap-2">
                        <button @click="createTracker" class="px-4 py-2 text-xs bg-green-700 hover:bg-green-600 text-gray-200 rounded">Create</button>
                        <button @click="showCreateForm = false" class="px-4 py-2 text-xs bg-gray-700 hover:bg-gray-600 text-gray-300 rounded">Cancel</button>
                    </div>
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
