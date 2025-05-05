<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    products: {
        type: Array,
        required: true,
    }
});
</script>
<template>
    <div class="flex flex-wrap justify-center gap-4 px-6 2xl:px-0 mt-6 py-6 pb-12">
        <Link v-for="(product, index) in products" :key="index" :href="product.link"
            class="bg-white rounded-lg shadow w-[243px] dark:bg-gray-800 border dark:border-gray-800 hover:scale-105 transition-transform duration-200">
        <img :src="product.image" alt="" class="w-full object-cover rounded-lg aspect-[1/1.2]" />
        <div class="px-2 py-1 pb-2">
            <h3 class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ product.name }}</h3>
            <p class="text-black dark:text-white font-bold">R${{ product.price.toFixed(2) }}</p>
        </div>
        </Link>
    </div>
</template>