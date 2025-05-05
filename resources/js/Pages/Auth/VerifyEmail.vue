<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    status: String,
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <Head title="Email Verification" />
    <AppLayout :hasPaddingTop="false">
    <div class="flex justify-center items-center min-h-screen font-sans pt-28 pb-12 lg:pt-0 lg:pb-0">
        <div class="flex lg:w-[600px] lg:h-[500px] shadow-lg rounded-lg overflow-hidden lg:flex-row flex-col">

            <div class="bg-white dark:bg-gray-800 p-10 flex flex-col justify-center items-center">
                <h2 class="text-2xl font-bold bg-clip-text bg-gradient-to-r from-[rgba(37,116,193,0.6)] to-[#0E76CE] mb-6 text-center text-transparent">
                    Verifique seu e-mail
                </h2>

                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400 text-center">
                    Antes de continuar, por favor verifique seu endereço de e-mail clicando no link que acabamos de enviar para você. 
                    Se você não recebeu o e-mail, ficaremos felizes em enviar outro.
                </div>

                <div v-if="verificationLinkSent" class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    Um novo link de verificação foi enviado para o e-mail cadastrado no seu perfil.
                </div>

                <form @submit.prevent="submit" class="w-full">
                    <div class="!mt-6 flex items-center justify-center">
                        <button type="submit"
                            class="bg-gradient-to-r px-6 from-[rgba(37,116,193,0.6)] to-[#0E76CE] text-white py-2 rounded-md hover:opacity-90 transition mx-auto"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                            Reenviar e-mail de verificação
                        </button>
                    </div>

                    <div class="mt-6 text-center">
                        <Link :href="route('profile.show')"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                            Editar Perfil
                        </Link>

                        <Link :href="route('logout')" method="post" as="button"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 ms-2">
                            Sair
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</AppLayout>

</template>
