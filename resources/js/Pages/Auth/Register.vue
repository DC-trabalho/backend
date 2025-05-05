<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import GoogleBtn from '@/Components/GoogleBtn.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

</script>


<template>
    <Head title="Crie uma conta" />
    <AppLayout :hasPaddingTop="false">

        <div class="flex justify-center items-center min-h-screen font-sans pt-28 pb-12 lg:pt-0 lg:pb-0">
            <div class="flex lg:w-[900px] lg:h-[500px] shadow-lg rounded-lg overflow-hidden lg:flex-row flex-col">

                <div
                    class="lg:w-1/2 bg-gradient-to-r to-[rgba(37,116,193,0.6)] from-[#0E76CE] text-white flex flex-col justify-center items-center p-4 py-8 sm:p-10">
                    <h2 class="text-2xl font-bold mb-2">Bem vindo de volta!</h2>
                    <p class="text-sm mb-6 text-center">para continuar conectado conosco, faça login com suas
                        informações pessoais.</p>
                    <Link :href="route('login')"
                        class="border border-white px-6 py-2 rounded-full hover:bg-white hover:text-blue-600 transition">Entrar</Link>
                </div>

                <div class="lg:w-1/2 bg-white dark:bg-gray-800 p-4 sm:p-10 flex flex-col justify-center items-center">
                    <h2
                        class="text-2xl font-bold bg-clip-text bg-gradient-to-r from-[rgba(37,116,193,0.6)] to-[#0E76CE]  mb-6 text-center text-transparent">
                        Crie uma conta</h2>

                    <GoogleBtn />

                    <form @submit.prevent="submit" class="space-y-2 w-full">

                        <div :class="[
                            'px-1 py-1 flex bg-[rgb(245,245,245)] dark:bg-gray-700 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500',
                            form.errors.name ? 'border border-red-500 rounded-md' : ''
                        ]">
                            <div
                                class="inline-flex border-0 border border-gray-300 items-center px-3 rounded-r-md bg-transparent text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 -960 960 960">
                                    <path
                                        d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z" />
                                </svg>
                            </div>
                            <input v-model="form.name" type="text" placeholder="Nome"
                                class="flex-grow border-0 block w-full rounded-l-md bg-transparent text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:dark:border-gray-600 focus:ring-0 focus:border-gray-300 sm:text-sm p-2 pl-0" />

                        </div>
                        <InputError :message="form.errors.name" class="text-red-500 text-sm mb-2" />

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
                        <div :class="[
                            'px-1 py-1 flex bg-[rgb(245,245,245)] dark:bg-gray-700 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500',
                            form.errors.password_confirmation ? 'border border-red-500 rounded-md' : ''
                        ]">
                            <div
                                class="inline-flex border-0 border border-gray-300 items-center px-3 rounded-r-md bg-transparent text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 -960 960 960">
                                    <path
                                        d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm0-80h480v-400H240v400Zm240-120q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80ZM240-160v-400 400Z" />
                                </svg>

                            </div>
                            <input v-model="form.password_confirmation" type="password" placeholder="Confirmar Senha"
                                class="flex-grow border-0 block w-full rounded-l-md bg-transparent text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:dark:border-gray-600 focus:ring-0 focus:border-gray-300 sm:text-sm p-2 pl-0" />

                        </div>
                        <InputError :message="form.errors.password_confirmation" class="text-red-500 text-sm mb-2" />
                        <div class="!mt-6 flex items-center justify-center">
                            <button type="submit"
                                class="bg-gradient-to-r px-6 from-[rgba(37,116,193,0.6)] to-[#0E76CE] text-white py-2 rounded-md hover:opacity-90 transition mx-auto">
                                Cadastrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </AppLayout>
</template>