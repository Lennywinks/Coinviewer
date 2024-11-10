<script setup>
import {Head, } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CreateForm from "@/Pages/Portfolio/Partials/CreateForm.vue";
import TransactionTable from "@/Pages/Portfolio/Partials/TransactionTable.vue";

const props = defineProps({
    'coins': Array,
    'transactions': Array
})
</script>

<template>
    <Head title="Portfolio" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Portfolio</h2>
        </template>

        <div class="flex flex-col items-center">
            <TransactionTable :transactions="transactions"></TransactionTable>
            <CreateForm :coins="coins"/>
        </div>

    </AuthenticatedLayout>
</template>


