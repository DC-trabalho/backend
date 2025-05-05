<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';

const props = defineProps({
    product: Object,
});

const stock = ref(props.product.stock)
const quantity = ref(1)
const selectedVariation = ref(props.product.variations[0])
const selectedImage = ref(selectedVariation.value?.image_path)

const increment = () => {
    if (quantity.value < stock.value) quantity.value++
}

const decrement = () => {
    if (quantity.value > 1) quantity.value--
}

const validateInput = () => {
    if (isNaN(quantity.value) || quantity.value < 1) {
        quantity.value = 1
    } else if (quantity.value > stock.value) {
        quantity.value = stock.value
    }
}

const selectVariation = (variation) => {
    selectedVariation.value = variation
    selectedImage.value = variation.image_path
}

const addToCart = async () => {
    try {
        const response = await fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                product_id: props.product.id,
                variation_id: selectedVariation.value.id,
                quantity: quantity.value,
            }),
        });

        const data = await response.json();

        if (response.ok) {
            alert('Produto adicionado ao carrinho!');
        } else {
            alert(data.message || 'Erro ao adicionar ao carrinho.');
        }
    } catch (error) {
        console.error(error);
        alert('Erro de rede ao adicionar ao carrinho.');
    }
};

</script>

<template>

    <Head :title="product.name" />
    <AppLayout>
        <div class="flex justify-center items-center min-h-screen font-sans pt-28 pb-12 lg:pt-0 lg:pb-0">
            <div
                class="flex lg:w-[900px] lg:h-[500px] shadow-lg rounded-lg overflow-hidden lg:flex-row flex-col relative">
                <Link :href="route('home')"
                    class="text-blue-500 transition-colors duration-200 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100 absolute top-2 left-6">
                <span class="text-sm">← Voltar para o inicio</span>
                </Link>

                <div
                    class="lg:w-1/2 bg-white dark:bg-gray-800 p-4 sm:p-10 sm:pr-5 flex flex-col justify-center items-center">
                    <img :src="'/storage/' + selectedImage" alt="Imagem do produto"
                        class="w-full h-full object-cover rounded-md" />
                </div>

                <div
                    class="lg:w-1/2 bg-white dark:bg-gray-800 p-4 sm:p-10 sm:pl-5 flex flex-col justify-center items-center">
                    <div
                        class="w-full h-full border border-gray-300 rounded-lg p-4 sm:p-10 space-y-4 flex flex-col justify-between">
                        <h2 class="text-3xl font-semibold text-gray-900 dark:text-white !mt-0">{{ product.name }}</h2>
                        <div class="text-4xl font-semibold text-blue-500 mt-4">R$ {{ product.price }}</div>

                        <div class="flex space-x-2 mt-4">
                            <button v-for="(variation, index) in product.variations" :key="index"
                                :style="{ backgroundColor: variation.colour }"
                                class="w-8 h-8 rounded-full border-2 hover:opacity-80"
                                @mouseenter="selectedImage = variation.image_path" @click="selectVariation(variation)"
                                :class="{ 'border-blue-500': selectedVariation === variation }"></button>
                        </div>

                        <div class="flex items-center mt-4">
                            <span class="text-sm font-medium text-gray-700 dark:text-white">Quantidade:</span>
                            <div class="flex items-center border rounded px-1 py-1 rounded-md">
                                <button @click="decrement" class="px-2 text-lg">-</button>
                                <input type="text" v-model.number="quantity"
                                    class="w-8 text-center bg-transparent outline-none p-0 border-0"
                                    @input="validateInput" />
                                <button @click="increment" class="px-2 text-lg">+</button>
                            </div>
                            <span class="text-sm text-gray-500 ml-2">{{ stock }} disponíveis</span>
                        </div>

                        <button @click="addToCart"
                            class="w-full bg-blue-500 text-white mt-6 py-2 rounded-lg font-semibold hover:bg-blue-600">
                            Adicionar ao carrinho
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
