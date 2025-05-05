<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ActionMessage from '@/Components/ActionMessage.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    category: Object,
    categories: Array,
});

const form = useForm({
    _method: 'PUT',
    name: props.category.name,
    banner: null,
    current_banner: props.category.banner,
    image_path: null,
    current_image: props.category.image_path,
    parent_id: props.category.parent_id || '',
});

const bannerPreview = ref(props.category.banner ? `/storage/${props.category.banner}` : null);
const imagePreview = ref(props.category.image_path ? `/storage/${props.category.image_path}` : null);

const handleBannerChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.banner = file;
        const reader = new FileReader();
        reader.onload = () => {
            bannerPreview.value = reader.result;
        };
        reader.readAsDataURL(file);
    }
};

const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.image_path = file;
        const reader = new FileReader();
        reader.onload = () => {
            imagePreview.value = reader.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    const data = new FormData();
    data.append('name', form.name);
    data.append('parent_id', form.parent_id || '');
    if (form.banner) data.append('banner', form.banner);
    if (form.image_path) data.append('image_path', form.image_path);

    form.post(route('categories.update', props.category.id), {
        data,
        forceFormData: true,
    });
};

const deleteCategory = () => {
    if (confirm("Você tem certeza que deseja deletar esta categoria?")) {
        form.delete(route('categories.destroy', props.category.id), {
            preserveScroll: true,
            onSuccess: () => window.location.href = route('categories.index'),
        });
    }
};
</script>

<template>
    <AppLayout title="Editar Categoria">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Editar Categoria
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
                        <InputLabel for="banner" value="Banner" />
                        <input type="file" accept="image/*" class="mt-1 block w-full" @change="handleBannerChange" />
                        <InputError :message="form.errors.banner" class="mt-2" />
                        <div v-if="bannerPreview" class="mt-2">
                            <img :src="bannerPreview" class="w-32 h-32 object-cover rounded" alt="Preview Banner" />
                        </div>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="image_path" value="Foto da Categoria" />
                        <input type="file" accept="image/*" class="mt-1 block w-full" @change="handleImageChange" />
                        <InputError :message="form.errors.image_path" class="mt-2" />
                        <div v-if="imagePreview" class="mt-2">
                            <img :src="imagePreview" class="w-32 h-32 object-cover rounded" alt="Preview Imagem" />
                        </div>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="parent_category" value="Categoria Pai" />
                        <select v-model="form.parent_id" id="parent_category" class="mt-1 block w-full form-select">
                            <option value="">Selecione uma categoria pai (se houver)</option>
                            <option v-for="parent in categories" :key="parent.id" :value="parent.id">
                                {{ parent.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.parent_id" class="mt-2" />
                    </div>

                    <SectionBorder class="col-span-6" />
                </template>

                <template #actions>
                    <ActionMessage :on="form.recentlySuccessful" class="me-3">Categoria salva.</ActionMessage>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Salvar Alterações
                    </PrimaryButton>

                    <DangerButton type="button" class="ml-2" @click="deleteCategory">
                        Deletar Categoria
                    </DangerButton>
                </template>
            </FormSection>
        </div>
    </AppLayout>
</template>
