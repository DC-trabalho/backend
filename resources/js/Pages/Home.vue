<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Carrosel from '@/Components/Carrosel.vue';
import { Head } from '@inertiajs/vue3';

</script>

<template>
    <Head title="Home" />
    <AppLayout>

        <div class="w-full">
            <img src="https://images.hdqwalls.com/wallpapers/dc-cw-all-superheroes-gs.jpg" alt="Landing Image"
                class="w-full object-cover object-center h-80 2xl:rounded-b-lg" />
        </div>

        <Carrosel />
        <Carrosel />
        <Carrosel />
        <Carrosel />
        <Carrosel />

    </AppLayout>
</template>
