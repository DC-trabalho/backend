<script setup>
const redirectToGoogle = () => {
    window.location.href = route('socialite.redirect', ['google']);
};
</script>
<template>
    <button @click="redirectToGoogle"
        class="w-full flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition mb-4">
        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="h-5 w-5" />
        <span>Continuar com o Google</span>
    </button>
</template>