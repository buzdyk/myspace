<script setup>
import SettingsLayout from "../../layouts/SettingsLayout.vue";

const props = defineProps({
    trackers: { type: Array, required: true },
    navigation: { type: Object, required: true }
})
</script>

<template>
    <SettingsLayout :navigation="props.navigation" current-tab="trackers">
        <!-- Existing Trackers List -->
        <div v-if="trackers.length > 0" class="mb-8">
            <div v-for="tracker in trackers" :key="tracker.id" class="mb-2 p-2 bg-gray-800 rounded">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="text-base text-gray-200">
                            {{ tracker.title }} <span class="text-xs text-gray-500">{{ tracker.type }}</span>
                        </div>
                    </div>
                    <div>
                        <a :href="`${props.navigation.thisLink}/trackers/${tracker.id}/edit`" class="px-3 py-1 text-xs bg-gray-700 hover:bg-gray-600 text-gray-300 rounded inline-block">Edit</a>
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
    </SettingsLayout>
</template>
