<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    category: Object,
});
</script>

<template>
    <AppLayout title="Detalhes da Categoria">
        <div class="py-10 max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Categoria: {{ category.name }}
                </h2>
                <div class="flex gap-2">
                    <Link :href="route('categories.index')"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-200 rounded hover:bg-gray-300 dark:hover:bg-gray-600">
                        ← Voltar
                    </Link>
                    <Link :href="route('categories.edit', category.id)"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-indigo-700">
                        Editar Categoria
                    </Link>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 space-y-4">
                <div v-if="category.banner">
                    <img :src="`/storage/${category.banner}`" alt="Banner da Categoria"
                        class="rounded w-full h-48 object-cover mb-4" />
                </div>

                <div>
                    <p class="text-gray-700 dark:text-gray-300"><strong>Nome:</strong> {{ category.name }}</p>
                </div>

                <div v-if="category.children && category.children.length">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mt-6">Subcategorias</h3>
                    <ul class="list-disc list-inside text-gray-700 dark:text-gray-300">
                        <li v-for="child in category.children" :key="child.id">
                            {{ child.name }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
