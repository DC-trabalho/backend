<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>

    <Head title="Reset Password" />
    <AppLayout :hasPaddingTop="false">
        <div class="flex justify-center items-center min-h-screen font-sans pt-28 pb-12 lg:pt-0 lg:pb-0">
            <div class="flex lg:w-[500px] lg:h-[500px] shadow-lg rounded-lg overflow-hidden lg:flex-row flex-col">

                <div class="bg-white dark:bg-gray-800 p-10 flex flex-col justify-center items-center w-full">
                    <h2
                        class="text-2xl font-bold bg-clip-text bg-gradient-to-r from-[rgba(37,116,193,0.6)] to-[#0E76CE] mb-6 text-center text-transparent">
                        Redefinir Senha
                    </h2>

                    <form @submit.prevent="submit" class="w-full max-w-md">
                        <div>
                            <InputLabel for="email" value="E-mail" />
                            <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required
                                autofocus autocomplete="username" />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="password" value="Nova Senha" />
                            <TextInput id="password" v-model="form.password" type="password" class="mt-1 block w-full"
                                required autocomplete="new-password" />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="password_confirmation" value="Confirmar Nova Senha" />
                            <TextInput id="password_confirmation" v-model="form.password_confirmation" type="password"
                                class="mt-1 block w-full" required autocomplete="new-password" />
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>

                        <div class="flex items-center justify-center mt-6">
                            <button type="submit"
                                class="bg-gradient-to-r px-6 from-[rgba(37,116,193,0.6)] to-[#0E76CE] text-white py-2 rounded-md hover:opacity-90 transition"
                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Redefinir Senha
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </AppLayout>

</template>
