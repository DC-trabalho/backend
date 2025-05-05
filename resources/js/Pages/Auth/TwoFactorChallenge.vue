<script setup>
import { nextTick, ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';

const recovery = ref(false);

const form = useForm({
    code: '',
    recovery_code: '',
});

const recoveryCodeInput = ref(null);
const codeInput = ref(null);

const toggleRecovery = async () => {
    recovery.value ^= true;

    await nextTick();

    if (recovery.value) {
        recoveryCodeInput.value.focus();
        form.code = '';
    } else {
        codeInput.value.focus();
        form.recovery_code = '';
    }
};

const submit = () => {
    form.post(route('two-factor.login'));
};
</script>

<template>

    <Head title="Two-factor Confirmation" />
    <AppLayout :hasPaddingTop="false">
    <div class="flex justify-center items-center min-h-screen font-sans pt-28 pb-12 lg:pt-0 lg:pb-0">
        <div class="flex lg:h-[500px] shadow-lg rounded-lg overflow-hidden lg:flex-row flex-col">

            <div class="bg-white dark:bg-gray-800 p-10 flex flex-col justify-center items-center w-full">
                <h2 class="text-2xl font-bold bg-clip-text bg-gradient-to-r from-[rgba(37,116,193,0.6)] to-[#0E76CE] mb-6 text-center text-transparent">
                    Autenticação em Duas Etapas
                </h2>

                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400 text-center">
                    <template v-if="!recovery">
                        Confirme o acesso à sua conta inserindo o código do aplicativo autenticador.
                    </template>
                    <template v-else>
                        Confirme o acesso à sua conta inserindo um dos seus códigos de recuperação de emergência.
                    </template>
                </div>

                <form @submit.prevent="submit" class="w-full max-w-md">
                    <div v-if="!recovery">
                        <InputLabel for="code" value="Código" />
                        <TextInput id="code" ref="codeInput" v-model="form.code" type="text" inputmode="numeric"
                            class="mt-1 block w-full" autofocus autocomplete="one-time-code" />
                        <InputError class="mt-2" :message="form.errors.code" />
                    </div>

                    <div v-else>
                        <InputLabel for="recovery_code" value="Código de Recuperação" />
                        <TextInput id="recovery_code" ref="recoveryCodeInput" v-model="form.recovery_code" type="text"
                            class="mt-1 block w-full" autocomplete="one-time-code" />
                        <InputError class="mt-2" :message="form.errors.recovery_code" />
                    </div>

                    <div class="flex items-center justify-center mt-6">
                        <button type="submit"
                            class="bg-gradient-to-r px-6 from-[rgba(37,116,193,0.6)] to-[#0E76CE] text-white py-2 rounded-md hover:opacity-90 transition"
                            :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Entrar
                        </button>
                    </div>

                    <div class="mt-6 text-center">
                        <button type="button"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100"
                            @click.prevent="toggleRecovery">
                            <template v-if="!recovery">
                                Usar um código de recuperação
                            </template>
                            <template v-else>
                                Usar um código de autenticação
                            </template>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</AppLayout>
</template>
