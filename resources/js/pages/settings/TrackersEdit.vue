<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import SettingsLayout from "../../layouts/SettingsLayout.vue";

const props = defineProps({
    tracker: { type: Object, required: true },
    navigation: { type: Object, required: true }
})

const message = ref('');

const editingTracker = ref({
    title: props.tracker.title,
    status: props.tracker.status
});

const updateTracker = () => {
    router.put(`/settings/trackers/${props.tracker.id}`, editingTracker.value, {
        onSuccess: () => {
            router.visit('/settings/trackers');
        },
        onError: (errors) => {
            message.value = 'Error updating tracker';
        }
    });
};

const deleteTracker = () => {
    if (!confirm(`Delete tracker "${props.tracker.title}"?`)) return;

    router.delete(`/settings/trackers/${props.tracker.id}`, {
        onSuccess: () => {
            router.visit('/settings/trackers');
        },
        onError: (errors) => {
            message.value = 'Error deleting tracker';
        }
    });
};

const resetMessage = () => {
    message.value = '';
};
</script>

<template>
    <SettingsLayout :navigation="props.navigation" current-tab="trackers">
        <h3 class="text-base text-gray-300">Edit Tracker</h3>

        <div class="mt-6">
            <label class="block text-sm text-gray-400 mb-2">Title</label>
            <input v-model="editingTracker.title" placeholder="Tracker Title" maxlength="255" class="w-full px-3 py-2 bg-gray-700 text-gray-200 focus:outline-none placeholder-gray-500 text-sm rounded" />
        </div>

        <div class="mt-3">
            <label class="block text-sm text-gray-400 mb-2">Status</label>
            <select v-model="editingTracker.status" class="w-full px-3 py-2 bg-gray-700 text-gray-200 outline-none text-sm rounded">
                <option value="active">active</option>
                <option value="paused">paused</option>
            </select>
        </div>

        <div class="mt-6">
            <button @click="updateTracker" class="px-4 py-2 text-xs bg-green-700 hover:bg-green-800 text-gray-200 rounded">Update Tracker</button>
        </div>

        <div class="mt-6">
            <button @click="deleteTracker" class="px-4 py-2 text-xs bg-red-700 hover:bg-red-800 text-gray-200 rounded">Delete Tracker</button>
        </div>

        <div v-if="message" class="mt-6 text-center text-sm text-red-400">
            {{ message }}
            <span @click="resetMessage" class="px-2 py-1 font-mono text-gray-400 hover:text-gray-200 cursor-pointer">X</span>
        </div>
    </SettingsLayout>
</template>
