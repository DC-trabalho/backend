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
import DangerButton from '@/Components/DangerButton.vue';
import { ref } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';

const props = defineProps({
    product: Object,
    categories: Array,
});

const form = useForm({
    _method: 'PUT',
    name: props.product.name,
    description: props.product.description,
    price: props.product.price,
    stock: props.product.stock,
    categories: props.product.categories.map(c => c.id),
    variations: props.product.variations.map(v => ({
        id: v.id,
        colour: v.colour,
        image: null,
        image_path: v.image_path,
    })),
});

const photoPreviews = ref([]);

const addVariation = () => {
    form.variations.push({ colour: '#000000', image: null, image_path: null });
};

const removeVariation = (index) => {
    form.variations.splice(index, 1);
    photoPreviews.value.splice(index, 1);
};

const handleFileChange = (e, index) => {
    const file = e.target.files[0];
    if (file) {
        form.variations[index].image = file;
        form.variations[index].image_path = null;

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

    form.categories.forEach(categoryId => {
        data.append('categories[]', categoryId);
    });
    form.variations.forEach((v, i) => {
        if (v.id) data.append(`variations[${i}][id]`, v.id);
        data.append(`variations[${i}][colour]`, v.colour);
        if (v.image) data.append(`variations[${i}][image]`, v.image);
    });

    form.post(route('products.update', props.product.id), {
        data,
        forceFormData: true,
    });
};

const deleteProduct = () => {
    if (confirm("Você tem certeza que deseja deletar este produto?")) {
        form.delete(route('products.destroy', props.product.id), {
            preserveScroll: true,
            onSuccess: () => window.location.href = route('products.index'),
        });
    }
};
</script>

<template>

    <Head title="Editar Produto" />

    <AppLayout title="Editar Produto">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Editar Produto
            </h2>
        </template>

        <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <FormSection @submitted="submit">

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
                        <TextInput id="price" v-model="form.price" type="number" step="0.01"
                            class="mt-1 block w-full" />
                        <InputError :message="form.errors.price" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <InputLabel for="stock" value="Estoque" />
                        <TextInput id="stock" v-model="form.stock" type="number" class="mt-1 block w-full" />
                        <InputError :message="form.errors.stock" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="categories" value="Categorias" />
                        <select id="categories" v-model="form.categories" multiple
                            class="mt-1 block w-full h-32 border-gray-300 rounded-md">
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.categories" class="mt-2" />
                    </div>

                    <SectionBorder class="col-span-6" />

                    <div class="col-span-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Variações</h3>

                        <div v-for="(variation, index) in form.variations" :key="index"
                            class="mt-4 border p-4 rounded-md dark:border-gray-700">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <InputLabel :for="'colour-' + index" value="Cor" />
                                    <input type="color" v-model="variation.colour" :id="'colour-' + index"
                                        class="mt-1 block w-20 h-10 rounded" />
                                </div>

                                <div>
                                    <InputLabel :for="'image-' + index" value="Imagem" />
                                    <input type="file" accept="image/*" class="mt-1 block w-full"
                                        @change="e => handleFileChange(e, index)" />
                                    <InputError :message="form.errors[`variations.${index}.image`]" class="mt-2" />
                                    <div v-if="photoPreviews[index] || variation.image_path" class="mt-2">
                                        <img :src="photoPreviews[index] || `/storage/${variation.image_path}`"
                                            class="w-24 h-24 object-cover border rounded" alt="Preview" />
                                    </div>
                                </div>
                            </div>

                            <SecondaryButton class="mt-4 text-red-600" type="button" @click="removeVariation(index)"
                                v-if="form.variations.length > 1">
                                Remover Variação
                            </SecondaryButton>
                        </div>

                        <SecondaryButton class="mt-4" type="button" @click="addVariation">
                            + Adicionar Variação
                        </SecondaryButton>
                    </div>
                </template>

                <template #actions>
                    <ActionMessage :on="form.recentlySuccessful" class="me-3">Salvo.</ActionMessage>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Salvar Alterações
                    </PrimaryButton>

                    <DangerButton type="button" class="ml-2 " @click="deleteProduct">
                        Deletar Produto
                    </DangerButton>
                </template>
            </FormSection>
        </div>
    </AppLayout>
</template>
