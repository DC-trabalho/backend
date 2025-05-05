<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ActionMessage from '@/Components/ActionMessage.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    parents: Array,
});

const preview = ref(null);

const form = useForm({
    name: '',
    parent_id: '',
    banner: null,
});

const handleBannerChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.banner = file;
        const reader = new FileReader();
        reader.onload = () => {
            preview.value = reader.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    const data = new FormData();
    data.append('name', form.name);
    data.append('parent_id', form.parent_id || '');
    if (form.banner) data.append('banner', form.banner);

    form.post(route('categories.store'), {
        data,
        forceFormData: true,
        onSuccess: () => {
            form.reset();
            preview.value = null;
        }
    });
};
</script>

<template>
    <AppLayout title="Criar Categoria">
        <div class="py-10 max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Nova Categoria
                </h2>
                <Link :href="route('categories.index')"
                    class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-200 rounded hover:bg-gray-300 dark:hover:bg-gray-600">
                ← Voltar
                </Link>
            </div>
            <FormSection @submitted="submit">
                <template #title>Criar Categoria</template>

                <template #description>
                    Preencha os campos para cadastrar uma nova categoria de produto.
                </template>

                <template #form>
                    <div class="col-span-6">
                        <InputLabel for="name" value="Nome" />
                        <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                    <div class="col-span-6">
                        <InputLabel for="parent_id" value="Categoria Pai (opcional)" />
                        <select id="parent_id" v-model="form.parent_id"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm">
                            <option value="">Nenhuma</option>
                            <option v-for="parent in parents" :key="parent.id" :value="parent.id">
                                {{ parent.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.parent_id" class="mt-2" />
                    </div>

                    <div class="col-span-6">
                        <InputLabel for="banner" value="Banner" />
                        <input type="file" accept="image/*" @change="handleBannerChange"
                            class="mt-1 block w-full text-sm" />
                        <InputError :message="form.errors.banner" class="mt-2" />

                        <div v-if="preview" class="mt-4">
                            <img :src="preview" alt="Preview" class="w-48 h-32 object-cover rounded border" />
                        </div>
                    </div>
                </template>

                <template #actions>
                    <ActionMessage :on="form.recentlySuccessful" class="me-3">Categoria salva.</ActionMessage>
                    <PrimaryButton :disabled="form.processing" :class="{ 'opacity-25': form.processing }">
                        Salvar Categoria
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
    </AppLayout>
</template>
