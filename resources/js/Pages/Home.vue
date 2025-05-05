<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Carrosel from '@/Components/Carrosel.vue';
import { Head } from '@inertiajs/vue3';
import ListProducts from '@/Components/ListProducts.vue';

const props = defineProps({
    carousels: Array,
    products: Array,
});
</script>

<template>

    <Head title="Home" />
    <AppLayout>

        <div class="w-full">
            <img src="https://images.hdqwalls.com/wallpapers/dc-cw-all-superheroes-gs.jpg" alt="Landing Image"
                class="w-full object-cover object-center h-80 2xl:rounded-b-lg" />
        </div>
        <template v-for="(carrosel, index) in carousels" :key="index">
            <Carrosel :title="carrosel.title" :items="carrosel.items" />
        </template>
        <ListProducts :products="products" />

    </AppLayout>
</template>
