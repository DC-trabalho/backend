<script setup>
import { Head, useForm, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed } from 'vue';

const props = defineProps({
  items: {
    type: Array,
    default: () => []
  }
});

const form = useForm({
  cartItemId: null,
  quantity: null,
});

const quantity = ref(1);

const increment = (item) => {
  if (item.quantity < item.product.stock) {
    item.quantity++;
    updateCartItemQuantity(item);
  }
};

const decrement = (item) => {
  if (item.quantity > 1) {
    item.quantity--;
    updateCartItemQuantity(item);
  }
};

const validateInput = (item) => {
  if (isNaN(item.quantity) || item.quantity < 1) {
    item.quantity = 1;
  } else if (item.quantity > item.product.stock) {
    item.quantity = item.product.stock;
  }
  updateCartItemQuantity(item);
};

const updateCartItemQuantity = (item) => {
  form.cartItemId = item.id;
  form.quantity = item.quantity;

  form.post(route('cart.update'), {
    preserveScroll: true,
    onSuccess: () => form.reset()
  });
};

const removeItemFromCart = (item) => {
  form.cartItemId = item.id;

  form.post(route('cart.remove'), {
    preserveScroll: true,
    onSuccess: () => form.reset()
  });
};

const total = computed(() => {
  return props.items && props.items.length > 0
    ? props.items.reduce((acc, item) => acc + (item.product.price * item.quantity), 0).toFixed(2)
    : '0.00';
});

const continuarCompra = () => {
  const items = props.items.map(item => ({
    name: item.product.name,
    quantity: item.quantity,
    price: item.product.price
  }));

  fetch(route('checkout'), {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({ items })
  })
    .then(response => response.json())
    .then(data => {
      if (data.init_point) {
        window.location.href = data.init_point;
      } else {
        alert('Houve um erro ao processar o pagamento.');
      }
    })
    .catch(error => {
      alert('Erro ao tentar criar a preferência de pagamento.');
    });
};
</script>

<template>

  <Head title="Carrinho" />
  <AppLayout>
    <div class="px-16 py-10 min-h-screen">
      <div class="flex justify-between items-center pb-2">
        <h1 class="text-xl font-semibold text-gray-700">Meu Carrinho</h1>
      </div>
      <span class="flex w-full h-1 bg-gray-500 rounded-full mt-1 mb-4"></span>

      <div v-if="props.items.length === 0" class="text-center text-gray-500">
        <p>Seu carrinho está vazio.</p>
      </div>

      <div v-for="item in props.items" :key="item.id"
        class="flex gap-4 border-b border-gray-300 pb-4 mb-4 items-center relative">
        <button
          class="text-gray-500 hover:text-red-500 p-0.5 border border-gray-300 rounded-full bg-white absolute -top-2.5 -left-2.5"
          @click="removeItemFromCart(item)">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 -960 960 960">
            <path
              d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
          </svg>
        </button>

        <img :src="'/storage/' + item.variation.image_path" alt="Imagem do produto" class="w-24 h-24 object-cover" />

        <div class="flex-1">
          <h2 class="font-medium">{{ item.product.name }}</h2>
          <p class="text-green-600 text-sm mt-1">Em estoque</p>
          <div class="flex items-center mt-2">
            <div :style="{ backgroundColor: item.variation.colour }"
              class="w-6 h-6 rounded-full border border-gray-400"></div>
          </div>
        </div>

        <div class="flex items-center">
          <div class="flex items-center border rounded px-1 py-1 rounded-md">
            <button @click="decrement(item)" class="px-2 text-lg">-</button>
            <input type="text" v-model.number="item.quantity"
              class="w-8 text-center bg-transparent outline-none p-0 border-0" @input="validateInput(item)" />
            <button @click="increment(item)" class="px-2 text-lg">+</button>
          </div>
        </div>

        <div class="ml-4 text-xl text-gray-400 font-normal">R$ {{ (item.product.price * item.quantity).toFixed(2) }}
        </div>
      </div>

      <div class="pt-4">
        <h2 class="font-semibold text-gray-600 mb-2">Resumo do pedido</h2>
        <div class="flex justify-between text-2xl font-medium border-t border-gray-300">
          <span>Total do Pedido</span>
          <span>R$ {{ total }}</span>
        </div>
      </div>
      <div class="flex justify-end items-center mt-4">
        <button @click="continuarCompra" class="bg-[#004900] text-white text-xl px-8 py-1 rounded-md">Pagar</button>
      </div>
    </div>
  </AppLayout>
</template>
