<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    categories: Object,
});
</script>

<template>
    <AppLayout title="Categorias">
        <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Lista de Categorias</h2>
                    <Link
                        :href="route('categories.create')"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition"
                    >
                        + Adicionar Categoria
                    </Link>
                </div>

                <div v-if="categories.data.length === 0">
                    <p class="text-gray-600 dark:text-gray-300">Nenhuma categoria encontrada.</p>
                </div>

                <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <Link
                        v-for="category in categories.data"
                        :key="category.id"
                        :href="route('categories.show', category.id)"
                        class="block border border-gray-300 dark:border-gray-700 rounded-md overflow-hidden hover:shadow-md transition bg-white dark:bg-gray-900"
                    >
                        <img
                            v-if="category.banner"
                            :src="`/storage/${category.banner}`"
                            alt="Banner da Categoria"
                            class="w-full h-40 object-cover"
                        />
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                {{ category.name }}
                            </h3>
                            <p
                                v-if="category.parent"
                                class="text-sm text-gray-500 dark:text-gray-400"
                            >
                                Subcategoria de {{ category.parent.name }}
                            </p>
                        </div>
                    </Link>
                </div>

                <div class="mt-6">
                    <Pagination :links="categories.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>