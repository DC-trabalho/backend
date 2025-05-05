<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>

    <Head title="Forgot Password" />

    <AppLayout :hasPaddingTop="false">
        <div class="flex justify-center items-center min-h-screen font-sans pt-28 pb-12 lg:pt-0 lg:pb-0">
            <div class="flex lg:w-[500px] lg:h-[500px] shadow-lg rounded-lg overflow-hidden lg:flex-row flex-col">

                <div class="bg-white dark:bg-gray-800 p-10 flex flex-col justify-center items-center w-full">
                    <h2
                        class="text-2xl font-bold bg-clip-text bg-gradient-to-r from-[rgba(37,116,193,0.6)] to-[#0E76CE] mb-6 text-center text-transparent">
                        Esqueceu sua senha?
                    </h2>

                    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400 text-center">
                        Sem problemas. Informe seu endereço de e-mail e enviaremos um link para que você possa redefinir
                        sua senha.
                    </div>

                    <div v-if="status" class="mb-4 font-medium text-sm text-green-600 dark:text-green-400 text-center">
                        {{ status }}
                    </div>

                    <form @submit.prevent="submit" class="w-full max-w-md">
                        <div>
                            <InputLabel for="email" value="E-mail" />
                            <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required
                                autofocus autocomplete="username" />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="flex items-center justify-center mt-6">
                            <button type="submit"
                                class="bg-gradient-to-r px-6 from-[rgba(37,116,193,0.6)] to-[#0E76CE] text-white py-2 rounded-md hover:opacity-90 transition"
                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Enviar link de redefinição
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </AppLayout>

</template>
