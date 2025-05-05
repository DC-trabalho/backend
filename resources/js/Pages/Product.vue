<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue'

const stock = 50
const quantity = ref(1)

const increment = () => {
    if (quantity.value < stock) quantity.value++
}

const decrement = () => {
    if (quantity.value > 1) quantity.value--
}

const validateInput = () => {
    if (isNaN(quantity.value) || quantity.value < 1) {
        quantity.value = 1
    } else if (quantity.value > stock) {
        quantity.value = stock
    }
}

</script>

<template>

    <Head title="Caneca Batman - Batmóvel" />
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
                    <img src="https://images.tcdn.com.br/img/img_prod/352023/90_caneca_dc_comics_batman_85_the_batmobile_10437_2_20e97caf3ab5ecfb5a13f4d668059e3b.jpg"
                        alt="Logo" class="w-full h-full object-cover rounded-md" />
                </div>

                <div
                    class="lg:w-1/2 bg-white dark:bg-gray-800 p-4 sm:p-10 sm:pl-5 flex flex-col justify-center items-center">
                    <div
                        class="w-full h-full border border-gray-300 rounded-lg p-4 sm:p-10 space-y-4 flex flex-col justify-between">

                        <h2 class="text-3xl font-semibold text-gray-900 dark:text-white !mt-0">Caneca Batman - Batmóvel
                        </h2>

                        <div class="flex items-center mt-1">
                            <span class="text-xs text-gray-500 dark:text-gray-400">4,5</span>
                            <div class="flex items-center ml-1 text-blue-500">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.561-.955L10 0l2.951 5.955 6.561.955-4.756 4.635 1.122 6.545z" />
                                </svg>
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.561-.955L10 0l2.951 5.955 6.561.955-4.756 4.635 1.122 6.545z" />
                                </svg>
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.561-.955L10 0l2.951 5.955 6.561.955-4.756 4.635 1.122 6.545z" />
                                </svg>
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.561-.955L10 0l2.951 5.955 6.561.955-4.756 4.635 1.122 6.545z" />
                                </svg>
                                <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.561-.955L10 0l2.951 5.955 6.561.955-4.756 4.635 1.122 6.545z" />
                                </svg>
                            </div>
                        </div>

                        <div class="text-4xl font-semibold text-blue-500 mt-4">R$29,99</div>

                        <div class="flex space-x-2">
                            <button
                                class="w-8 h-8 rounded-full bg-black border-2 hover:opacity-80 border-gray-400"></button>
                            <button class="w-8 h-8 rounded-full bg-blue-600 border-2 hover:opacity-80"></button>
                        </div>

                        <div class="flex items-center">
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



                        <button class="w-full bg-blue-200 text-blue-700 mt-6 py-2 rounded-lg font-semibold">
                            Adicionar ao carrinho
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>
