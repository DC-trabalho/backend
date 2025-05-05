<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import GoogleBtn from '@/Components/GoogleBtn.vue';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

</script>

<template>

    <Head title="Login" />
    <AppLayout :hasPaddingTop="false">

        <div class="flex justify-center items-center min-h-screen font-sans pt-28 pb-12 lg:pt-0 lg:pb-0">
            <div class="flex lg:w-[900px] lg:h-[500px] shadow-lg rounded-lg overflow-hidden lg:flex-row flex-col">

                <div class="lg:w-1/2 bg-white dark:bg-gray-800 p-4 sm:p-10 flex flex-col justify-center items-center">
                    <h2
                        class="text-2xl font-bold bg-clip-text bg-gradient-to-r from-[rgba(37,116,193,0.6)] to-[#0E76CE]  mb-6 text-center text-transparent">
                        Entre na sua conta</h2>

                    <GoogleBtn />

                    <div v-if="status" class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ status }}
                    </div>

                    <form @submit.prevent="submit" class="space-y-2 w-full">
                        <div :class="[
                            'px-1 py-1 flex bg-[rgb(245,245,245)] dark:bg-gray-700 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500',
                            form.errors.email ? 'border border-red-500 rounded-md' : ''
                        ]">
                            <div
                                class="inline-flex border-0 border border-gray-300 items-center px-3 rounded-r-md bg-transparent text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 -960 960 960">
                                    <path
                                        d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm320-280L160-640v400h640v-400L480-440Zm0-80 320-200H160l320 200ZM160-640v-80 480-400Z" />
                                </svg>
                            </div>
                            <input v-model="form.email" type="text" placeholder="Email"
                                class="flex-grow border-0 block w-full rounded-l-md bg-transparent text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:dark:border-gray-600 focus:ring-0 focus:border-gray-300 sm:text-sm p-2 pl-0" />
                        </div>
                        <InputError :message="form.errors.email" class="text-red-500 text-sm mb-2" />

                        <div :class="[
                            'px-1 py-1 flex bg-[rgb(245,245,245)] dark:bg-gray-700 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500',
                            form.errors.password ? 'border border-red-500 rounded-md' : ''
                        ]">
                            <div
                                class="inline-flex border-0 border border-gray-300 items-center px-3 rounded-r-md bg-transparent text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 -960 960 960">
                                    <path
                                        d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm0-80h480v-400H240v400Zm240-120q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80ZM240-160v-400 400Z" />
                                </svg>

                            </div>
                            <input v-model="form.password" type="password" placeholder="Senha"
                                class="flex-grow border-0 block w-full rounded-l-md bg-transparent text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:dark:border-gray-600 focus:ring-0 focus:border-gray-300 sm:text-sm p-2 pl-0" />

                        </div>
                        <InputError :message="form.errors.password" class="text-red-500 text-sm mb-2" />
                        <div class="!mt-6 flex items-center justify-center">
                            <button type="submit"
                                class="bg-gradient-to-r px-6 from-[rgba(37,116,193,0.6)] to-[#0E76CE] text-white py-2 rounded-md hover:opacity-90 transition mx-auto">
                                Entrar
                            </button>
                        </div>

                    </form>
                    <Link :href="route('password.request')"
                        class="pt-4 underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    Esqueceu sua senha?
                    </Link>
                </div>

                <div
                    class="lg:w-1/2 bg-gradient-to-r to-[rgba(37,116,193,0.6)] from-[#0E76CE] text-white flex flex-col justify-center items-center p-4 py-8 sm:p-10">
                    <h2 class="text-2xl font-bold mb-2">Não tem conta?</h2>
                    <p class="text-sm mb-6 text-center">
                        Crie uma conta para acessar recursos exclusivos e personalizar sua experiência. É rápido e
                        fácil!
                    </p>
                    <Link :href="route('register')"
                        class="border border-white px-6 py-2 rounded-full hover:bg-white hover:text-blue-600 transition">
                    Registre-se</Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
