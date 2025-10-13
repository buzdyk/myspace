<script setup>
import Navigation from "../components/Navigation.vue";

const props = defineProps({
    navigation: { type: Object, required: true },
    currentTab: { type: String, required: true }
})
</script>

<template>
    <div class="h-screen flex items-center justify-center font-mono">
        <div class="relative w-3/4 text-sm selection:bg-red-700 selection:text-white">
            <div class="max-w-2xl mx-auto">
                <div class="text-lg selection:bg-red-700 selection:text-white">
                    <div class="flex justify-start text-xs">
                        <a
                            :href="`${navigation.thisLink}`"
                            :class="currentTab === 'general' ? 'bg-gray-700' : 'hover:bg-gray-700'"
                            class="block px-5 py-1 mr-4 text-center text-gray-400"
                        >
                            General
                        </a>
                        <a
                            :href="`${navigation.thisLink}/trackers`"
                            :class="currentTab === 'trackers' ? 'bg-gray-700' : 'hover:bg-gray-700'"
                            class="block px-5 py-1 text-center text-gray-400"
                        >
                            Trackers
                        </a>
                    </div>
                </div>

                <div class="mt-10">
                    <slot />
                </div>
            </div>
        </div>

        <Navigation active="settings" />
    </div>
</template>
