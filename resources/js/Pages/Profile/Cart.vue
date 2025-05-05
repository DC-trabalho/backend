<script setup>
import { Head } from '@inertiajs/vue3';
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

    <Head title="Carrinho" />
    <AppLayout>
        <div class="px-16 py-10">

            <div class="flex justify-between items-center pb-2">
                <h1 class="text-xl font-semibold text-gray-700">Meu Carrinho</h1>
            </div>
            <span class="flex w-full h-1 bg-gray-500 rounded-full mt-1 mb-4"></span>

            <div v-for="a in ['', '']" class="flex gap-4 border-b border-gray-300 pb-4 mb-4 items-center relative">
                <button
                    class="text-gray-500 hover:text-red-500 p-0.5 border border-gray-300 rounded-full bg-white absolute -top-2.5 -left-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor"
                        viewBox="0 -960 960 960">

                        <path
                            d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                    </svg>
                </button>

                <img src="https://images.prismic.io/batman-escape/ZfDILEmNsf2sHiGL_BGCA-Facebook-Cover.webp?auto=format,compress"
                    alt="Caneca" class="w-24 h-24 object-cover" />
                <div class="flex-1">
                    <h2 class="font-medium">Caneca Batman - Batmóvel</h2>
                    <p class="text-green-600 text-sm mt-1">Em estoque</p>
                    <div class="flex items-center mt-2">
                        <div class="w-6 h-6 bg-black rounded-full border border-gray-400"></div>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center border rounded px-1 py-1 rounded-md">
                        <button @click="decrement" class="px-2 text-lg">-</button>
                        <input type="text" v-model.number="quantity"
                            class="w-8 text-center bg-transparent outline-none p-0 border-0" @input="validateInput" />
                        <button @click="increment" class="px-2 text-lg">+</button>
                    </div>
                </div>
                <div class="ml-4 text-xl text-gray-400 font-normal">R$29,99</div>
            </div>

            <div class="pt-4">
                <h2 class="font-semibold text-gray-600 mb-2">Resumo do pedido</h2>
                <div class="flex justify-between text-2xl font-medium border-t border-gray-300">
                    <span>Total do Pedido</span>
                    <span>R$99,98</span>
                </div>
            </div>
            <div class="flex justify-end items-center mt-4">
                <button class="bg-[#004900] text-white text-xl px-8 py-1 rounded-md">continuar</button>
            </div>

        </div>
    </AppLayout>
</template>