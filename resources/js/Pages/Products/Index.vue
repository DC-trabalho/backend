<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { Link, Head } from '@inertiajs/vue3';

const props = defineProps({
    products: Object
});
</script>

<template>

    <Head title="Produtos" />
    <AppLayout title="Produtos">
        <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">


                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Lista de Produtos</h2>
                    <Link :href="route('products.create')"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition">
                    + Adicionar Produto
                    </Link>
                </div>

                <div v-if="products.data.length === 0">
                    <p class="text-gray-600 dark:text-gray-300">Nenhum produto encontrado.</p>
                </div>

                <div v-else class="space-y-4">
                    <Link v-for="product in products.data" :key="product.id" :href="route('products.show', product.id)"
                        class="block border border-gray-300 dark:border-gray-700 rounded-md p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ product.name }}
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 truncate">
                        {{ product.description }}
                    </p>
                    </Link>
                </div>

                <div class="mt-6">
                    <Pagination :links="products.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
