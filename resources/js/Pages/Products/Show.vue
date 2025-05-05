<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, Head } from '@inertiajs/vue3';

const props = defineProps({
    product: Object,
});
</script>

<template>

    <Head title="Detalhes do Produto" />

    <AppLayout>
        <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Detalhes do Produto: {{ product.name }}
                </h2>
                <div class="flex gap-2">
                    <Link :href="route('products.index')"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-200 rounded hover:bg-gray-300 dark:hover:bg-gray-600">
                    ← Voltar
                    </Link>
                    <Link :href="route('products.edit', product.id)"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    Editar Produto
                    </Link>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ product.name }}</h3>
                <p class="text-gray-700 dark:text-gray-300 mb-2"><strong>Descrição:</strong> {{ product.description }}
                </p>
                <p class="text-gray-700 dark:text-gray-300 mb-2"><strong>Preço:</strong> R$ {{
                    Number(product.price).toFixed(2) }}</p>
                <p class="text-gray-700 dark:text-gray-300 mb-4"><strong>Estoque:</strong> {{ product.stock }}</p>

                <div v-if="product.categories && product.categories.length">
                    <h4 class="text-md font-semibold text-gray-800 dark:text-white mb-2">Categorias:</h4>
                    <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 mb-4">
                        <li v-for="category in product.categories" :key="category.id">
                            {{ category.name }}
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-md font-semibold text-gray-800 dark:text-white mb-2">Variações:</h4>
                    <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3">
                        <div v-for="variation in product.variations" :key="variation.id"
                            class="border rounded p-4 dark:border-gray-700">
                            <div class="mb-2 flex items-center gap-2">
                                <span class="block w-5 h-5 rounded-full"
                                    :style="{ backgroundColor: variation.colour }"></span>
                                <span class="text-gray-700 dark:text-gray-300">{{ variation.colour }}</span>
                            </div>

                            <div v-if="variation.image_path">
                                <img :src="`/storage/${variation.image_path}`"
                                    class="w-full h-40 object-cover rounded" />
                            </div>
                            <div v-else class="text-gray-400 dark:text-gray-500">Sem imagem</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
