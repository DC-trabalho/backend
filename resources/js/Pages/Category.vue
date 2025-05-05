<script setup>
import ListProducts from '@/Components/ListProducts.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    category: Object,
    products: Object,
});

const sort = ref(new URLSearchParams(location.search).get('sort') || 'destaque');

watch(sort, value => {
    router.get(route('category', props.category.id), { sort: value }, {
        preserveScroll: true,
        preserveState: true,
    });
});
</script>

<template>

    <Head :title="category.name" />
    <AppLayout>
        <div class="h-80 w-full bg-cover bg-center bg-no-repeat object-center 2xl:mt-6 2xl:rounded-lg" :style="{
            backgroundImage: `url(/storage/${category.banner})`,
        }">
            <h1 class="pt-12 text-center text-5xl font-bold text-white">{{ category.name }}</h1>
        </div>

        <div class="font-sans">
            <Link :href="route('home')"
                class="px-12 text-blue-500 transition-colors duration-200 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100">
            <span class="text-sm">← Voltar para o início</span>
            </Link>

            <div class="mt-6 flex items-center justify-end px-6">
                <label class="mr-2 text-base text-gray-700 dark:text-gray-300">Classificar por</label>
                <select v-model="sort"
                    class="rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                    <option value="destaque">Destaque</option>
                    <option value="menor">Menor Preço</option>
                    <option value="maior">Maior Preço</option>
                </select>
            </div>

            <ListProducts :products="products.data" />
            <div class="px-6 mt-6">
                <Pagination :links="products.links" />
            </div>
        </div>
    </AppLayout>
</template>
