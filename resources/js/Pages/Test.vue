<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import {ref} from "vue";

const props = defineProps({
    testValue: Number,
});

function increment(value) {
    return value + 1;
}

let test = ref(props.testValue);
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Test</h2>
        </template>
        <div>
            <div class="flex justify-center font-semibold text-xl">
                <h3>{{ test }}</h3>
            </div>
            <div class="flex justify-center font-semibold text-xl">
                <button @click="test++">
                    Click this
                </button>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
