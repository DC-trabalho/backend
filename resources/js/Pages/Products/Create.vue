<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import ActionMessage from '@/Components/ActionMessage.vue';
import { reactive, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    description: '',
    price: '',
    stock: '',
    variations: [
        { colour: '', image: null }
    ],
});

const photoPreviews = ref([]);

const addVariation = () => {
    form.variations.push({ colour: '', image: null });
};

const removeVariation = (index) => {
    form.variations.splice(index, 1);
    photoPreviews.value.splice(index, 1);
};

const handleFileChange = (e, index) => {
    const file = e.target.files[0];
    if (file) {
        form.variations[index].image = file;

        const reader = new FileReader();
        reader.onload = () => {
            photoPreviews.value[index] = reader.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    const data = new FormData();
    data.append('name', form.name);
    data.append('description', form.description);
    data.append('price', form.price);
    data.append('stock', form.stock);

    form.variations.forEach((v, i) => {
        data.append(`variations[${i}][colour]`, v.colour);
        data.append(`variations[${i}][image]`, v.image);
    });

    form.post(route('products.store'), {
        data,
        forceFormData: true,
        onSuccess: () => {
            form.reset();
            photoPreviews.value = [];
        },
    });
};
</script>

<template>
    <AppLayout title="Criar Produto">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Criar Produto
            </h2>
        </template>

        <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <FormSection @submitted="submit">
                <template #title>Informações do Produto</template>

                <template #description>
                    Preencha os dados do produto e adicione as variações (cores e imagens).
                </template>

                <template #form>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="name" value="Nome" />
                        <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="description" value="Descrição" />
                        <TextInput id="description" v-model="form.description" type="text" class="mt-1 block w-full" />
                        <InputError :message="form.errors.description" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <InputLabel for="price" value="Preço" />
                        <TextInput id="price" v-model="form.price" type="number" step="0.01" class="mt-1 block w-full" />
                        <InputError :message="form.errors.price" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <InputLabel for="stock" value="Estoque" />
                        <TextInput id="stock" v-model="form.stock" type="number" class="mt-1 block w-full" />
                        <InputError :message="form.errors.stock" class="mt-2" />
                    </div>

                    <SectionBorder class="col-span-6" />

                    <div class="col-span-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Variações</h3>

                        <div v-for="(variation, index) in form.variations" :key="index" class="mt-4 border p-4 rounded-md">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <InputLabel :for="'colour-' + index" value="Cor (hex)" />
                                    <input
    :id="'colour-' + index"
    type="color"
    v-model="variation.colour"
    class="mt-1 block w-20 h-10 rounded"
    title="Escolha uma cor"
/>

                                    <InputError :message="form.errors[`variations.${index}.colour`]" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel :for="'image-' + index" value="Imagem" />
                                    <input type="file" accept="image/*" class="mt-1 block w-full" @change="e => handleFileChange(e, index)" />
                                    <InputError :message="form.errors[`variations.${index}.image`]" class="mt-2" />
                                    <div v-if="photoPreviews[index]" class="mt-2">
                                        <img :src="photoPreviews[index]" class="w-32 h-32 object-cover rounded border" />
                                    </div>
                                </div>
                            </div>

                            <SecondaryButton class="mt-4 text-red-600" type="button" @click="removeVariation(index)" v-if="form.variations.length > 1">
                                Remover Variação
                            </SecondaryButton>
                        </div>

                        <SecondaryButton class="mt-4" type="button" @click="addVariation">
                            + Adicionar Variação
                        </SecondaryButton>
                    </div>
                </template>

                <template #actions>
                    <ActionMessage :on="form.recentlySuccessful" class="me-3">Produto salvo.</ActionMessage>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Salvar Produto
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
    </AppLayout>
</template>
