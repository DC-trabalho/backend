<script setup>
import { ref } from 'vue';
import { Head, Link, router, } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import Footer from '@/Components/Footer.vue';
import { debounce } from 'lodash';
import { route } from 'ziggy-js';

const props = defineProps({
    title: String,
    hasPaddingTop: {
        type: Boolean,
        default: true,
    },
});

const showingNavigationDropdown = ref(false);

const logout = () => {
    router.post(route('logout'));
};

const searchQuery = ref('');
const searchResults = ref([]);

const fetchSearchResults = async () => {
    if (searchQuery.value.trim() === '') {
        searchResults.value = [];
        return;
    }

    try {
        const response = await fetch(`/search?query=${searchQuery.value}`);
        const data = await response.json();

        searchResults.value = data;
    } catch (error) {
        console.error('Erro ao buscar resultados:', error);
    }
};

const debounceSearch = debounce(fetchSearchResults, 300);

const clearResults = () => {
    setTimeout(() => {
        searchResults.value = [];
    }, 300);
};
</script>

<template>
    <div>

        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <nav :class="[
                'fixed top-0 left-0 w-full z-50 transition duration-300 backdrop-blur',
                isScrolled ? 'bg-white/80 dark:bg-gray-800/70 shadow-md' : 'bg-white dark:bg-gray-800'
            ]">

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('home')">
                                <ApplicationMark class="block h-9 w-auto" />
                                </Link>
                            </div>

                            <div class="hidden space-x-4 sm:-my-px sm:ms-10 md:flex">
                                <NavLink :href="route('home')" :active="route().current('home')">
                                    Home
                                </NavLink>
                                <NavLink :href="route('home') + '#sobre'">
                                    Sobre
                                </NavLink>
                                <NavLink v-if="$page.props.auth.user && $page.props.auth.user.type === 'admin'"
                                    :href="route('categories.index')" :active="route().current('categories.index')">
                                    Categorias
                                </NavLink>
                                <NavLink v-if="$page.props.auth.user && $page.props.auth.user.type === 'admin'"
                                    :href="route('products.index')" :active="route().current('products.index')">
                                    Produtos
                                </NavLink>
                            </div>
                        </div>

                        <div class="flex-1 flex items-center justify-center px-4">
                            <div class="relative w-full max-w-lg">
                                <div
                                    class="flex rounded-md bg-white dark:bg-gray-700 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500">
                                    <input v-model="searchQuery" @input="debounceSearch" @click="debounceSearch"
                                        @blur="clearResults" type="text" placeholder="Pesquise..."
                                        class="flex-grow dark:border-gray-600 border-gray-300 block w-full rounded-l-md bg-transparent text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:dark:border-gray-600 focus:ring-0 focus:border-gray-300 sm:text-sm p-2" />
                                    <button type="button"
                                        class="inline-flex dark:border-gray-600 border-l-0 border border-gray-300 items-center px-3 rounded-r-md bg-transparent text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103 10.5a7.5 7.5 0 0013.15 6.15z" />
                                        </svg>
                                    </button>
                                </div>

                                <div v-if="searchResults.length"
                                    class="absolute z-10 mt-1 w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-lg">
                                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                                        <li v-for="(result, index) in searchResults" :key="index"
                                            class="hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer">
                                            <Link :href="route('product', result.id)" class="px-4 py-2 block w-full h-full">
                                            {{ result.name }}
                                            </Link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="hidden sm:flex md:ms-6 gap-x-2">
                            <NavLink :href="route('cart')" :active="route().current('cart')"
                                class="hidden sm:inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                    stroke="currentColor" class="h-6 w-6" width="24px" fill="currentColor">
                                    <path
                                        d="M240-80q-33 0-56.5-23.5T160-160v-480q0-33 23.5-56.5T240-720h80q0-66 47-113t113-47q66 0 113 47t47 113h80q33 0 56.5 23.5T800-640v480q0 33-23.5 56.5T720-80H240Zm0-80h480v-480h-80v80q0 17-11.5 28.5T600-520q-17 0-28.5-11.5T560-560v-80H400v80q0 17-11.5 28.5T360-520q-17 0-28.5-11.5T320-560v-80h-80v480Zm160-560h160q0-33-23.5-56.5T480-800q-33 0-56.5 23.5T400-720ZM240-160v-480 480Z" />

                                </svg>
                            </NavLink>
                            <div v-if="$page.props.auth.user" class="relative flex items-center">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button
                                            class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 focus:dark:border-gray-700 transition">
                                            <img class="size-8 rounded-full object-cover select-none"
                                                :src="$page.props.auth.user.profile_photo_url"
                                                :alt="$page.props.auth.user.name">
                                        </button>
                                    </template>

                                    <template #content>
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Sua conta
                                        </div>

                                        <DropdownLink :href="route('profile.show')">
                                            Gerenciar Perfil
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.jetstream.hasApiFeatures"
                                            :href="route('api-tokens.index')">
                                            API Tokens
                                        </DropdownLink>

                                        <div class="border-t border-gray-200 dark:border-gray-600" />

                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                Sair
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                            <NavLink v-else :href="route('login')"
                                :active="route().current('login') || route().current('register')"
                                class="hidden sm:inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" stroke="currentColor"
                                    class="size-8" fill="currentColor">
                                    <path
                                        d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q53 0 100-15.5t86-44.5q-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160Zm0-360q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm0-60Zm0 360Z" />
                                </svg>
                            </NavLink>
                        </div>

                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 dark:text-gray-300 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
                                @click="showingNavigationDropdown = !showingNavigationDropdown">
                                <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{ 'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path
                                        :class="{ 'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }"
                    class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('home')" :active="route().current('home')">
                            Home
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('home') + '#sobre'">
                            Sobre
                        </ResponsiveNavLink>
                    </div>

                    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                        <div class="flex items-center px-4" v-if="$page.props.auth.user">
                            <div class="shrink-0 me-3">
                                <img class="size-10 rounded-full object-cover select-none"
                                    :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                            </div>

                            <div>
                                <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('cart')" :active="route().current('cart')">
                                <div class="flex items-center px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                        width="24px" fill="currentColor">
                                        <path
                                            d="M240-80q-33 0-56.5-23.5T160-160v-480q0-33 23.5-56.5T240-720h80q0-66 47-113t113-47q66 0 113 47t47 113h80q33 0 56.5 23.5T800-640v480q0 33-23.5 56.5T720-80H240Zm0-80h480v-480h-80v80q0 17-11.5 28.5T600-520q-17 0-28.5-11.5T560-560v-80H400v80q0 17-11.5 28.5T360-520q-17 0-28.5-11.5T320-560v-80h-80v480Zm160-560h160q0-33-23.5-56.5T480-800q-33 0-56.5 23.5T400-720ZM240-160v-480 480Z" />
                                    </svg>
                                    <span class="ms-3">Carrinho</span>
                                </div>
                            </ResponsiveNavLink>
                            <div v-if="$page.props.auth.user">
                                <ResponsiveNavLink :href="route('profile.show')"
                                    :active="route().current('profile.show')">
                                    Gerenciar Perfil
                                </ResponsiveNavLink>

                                <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures"
                                    :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                                    API Tokens
                                </ResponsiveNavLink>

                                <form method="POST" @submit.prevent="logout">
                                    <ResponsiveNavLink as="button">
                                        Sair
                                    </ResponsiveNavLink>
                                </form>
                            </div>
                            <div v-else>
                                <ResponsiveNavLink :href="route('login')"
                                    :active="route().current('login') || route().current('register')">
                                    <div class="flex items-center px-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                            width="24px" fill="currentColor">
                                            <path
                                                d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q53 0 100-15.5t86-44.5q-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160Zm0-360q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm0-60Zm0 360Z" />
                                        </svg>
                                        <span class="ms-3">Entrar</span>
                                    </div>
                                </ResponsiveNavLink>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <main :class="[hasPaddingTop ? 'pt-16' : '', '2xl:max-w-7xl mx-auto']">
                <slot />
            </main>

            <Footer />
        </div>
    </div>
</template>
