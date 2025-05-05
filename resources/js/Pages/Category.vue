<script setup>
import ListProducts from '@/Components/ListProducts.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const sort = ref('destaque');

const products = ref([
    {
        name: 'Caneca Batman - Batmóvelaaaaaaaaaa',
        price: 29.99,
        image: 'https://images.prismic.io/batman-escape/ZfDILEmNsf2sHiGL_BGCA-Facebook-Cover.webp?auto=format,compress',
        link: '/product/1',
    },
    {
        name: 'Caneca Batman - Batmóvelaaaaaaaaaa',
        price: 29.99,
        image: 'https://images.prismic.io/batman-escape/ZfDILEmNsf2sHiGL_BGCA-Facebook-Cover.webp?auto=format,compress',
        link: '/product/1',
    },
    {
        name: 'Caneca Batman - Batmóvelaaaaaaaaaa',
        price: 29.99,
        image: 'https://images.prismic.io/batman-escape/ZfDILEmNsf2sHiGL_BGCA-Facebook-Cover.webp?auto=format,compress',
        link: '/product/1',
    },
    {
        name: 'Caneca Batman - Batmóvelaaaaaaaaaa',
        price: 29.99,
        image: 'https://images.prismic.io/batman-escape/ZfDILEmNsf2sHiGL_BGCA-Facebook-Cover.webp?auto=format,compress',
        link: '/product/1',
    },
    {
        name: 'Caneca Batman - Batmóvelaaaaaaaaaa',
        price: 29.99,
        image: 'https://images.prismic.io/batman-escape/ZfDILEmNsf2sHiGL_BGCA-Facebook-Cover.webp?auto=format,compress',
        link: '/product/1',
    },
]);

const sortedProducts = computed(() => {
    if (sort.value === 'menor') {
        return [...products.value].sort((a, b) => a.price - b.price);
    } else if (sort.value === 'maior') {
        return [...products.value].sort((a, b) => b.price - a.price);
    }
    return products.value;
});
</script>
<template>

    <Head title="Categoria Batman" />
    <AppLayout>
        <div class="h-80 w-full bg-cover bg-center bg-no-repeat object-center 2xl:mt-6 2xl:rounded-lg" :style="{
            backgroundImage: `url('https://images.prismic.io/batman-escape/ZfDILEmNsf2sHiGL_BGCA-Facebook-Cover.webp?auto=format,compress')`,
        }">
            <h1 class="pt-12 text-center text-5xl font-bold text-white">Batman</h1>
        </div>
        <div class="font-sans">
            <Link :href="route('home')"
                class="px-12 text-blue-500 transition-colors duration-200 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100">
            <span class="text-sm">← Voltar para o inicio</span>
            </Link>

            <div class="mt-6 flex items-center justify-end px-6">
                <label class="text-bold mr-2 text-base text-gray-700 dark:text-gray-300">Classificar por</label>
                <select v-model="sort"
                    class="rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                    <option value="destaque">Destaque</option>
                    <option value="menor">Menor Preço</option>
                    <option value="maior">Maior Preço</option>
                </select>
            </div>

            <ListProducts :products="sortedProducts" />
        </div>
    </AppLayout>
</template>
