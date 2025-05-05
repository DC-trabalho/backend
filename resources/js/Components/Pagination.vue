<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: Array
});
</script>

<template>
    <div class="flex flex-wrap mt-4 justify-center">
        <template v-for="(link, key) in links" :key="key">
            <div v-if="link.url === null" v-html="link.label" class="px-4 py-2 text-sm text-gray-400"></div>
            <Link
                v-else
                :href="link.url"
                v-html="link.label"
                class="px-4 py-2 text-sm border rounded mx-1"
                :class="{
                    'bg-indigo-500 text-white': link.active,
                    'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700': !link.active
                }"
            />
        </template>
    </div>
</template>
