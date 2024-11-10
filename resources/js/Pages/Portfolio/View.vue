<script setup>
import {Head, router,} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CreateForm from "@/Pages/Portfolio/Partials/CreateForm.vue";
import TransactionTable from "@/Pages/Portfolio/Partials/TransactionTable.vue";
import QuoteRadioButtons from "@/Components/QuoteRadioButtons.vue";

const props = defineProps({
    'coins': Array,
    'transactions': Array
})

const handleFilter = (filter) => {
    router.get(
        '/portfolio',
        {
            ...props.filters,
            ...filter
        },
        {
            preserveState: true, replace: true,
            preserveScroll: true
        }
    )
}
</script>

<template>
    <Head title="Portfolio" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Portfolio</h2>
                <QuoteRadioButtons @filter="handleFilter"/>
            </div>
        </template>

        <div class="flex flex-col items-center">
            <TransactionTable :transactions="transactions"></TransactionTable>
            <CreateForm :coins="coins"/>
        </div>

    </AuthenticatedLayout>
</template>


