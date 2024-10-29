<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import PriceChart from "@/Components/PriceChart.vue";
import QuoteRadioButtons from "@/Components/QuoteRadioButtons.vue";
import CoinTable from "@/Pages/Overview/Partials/CoinTable.vue";
import {throttle} from "lodash/function.js";

const props = defineProps(['coinPrices', 'coins', 'filters'])

const handleFilter = throttle((filter) => {
    console.log(filter)
    router.get(
        '/overview',
        {
            ...props.filters,
            ...filter
        },
        {
            preserveState: true, replace: true,
            preserveScroll: true
        }
    )
}, 300)

</script>

<template>
    <Head title="Overview" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Overview</h2>
                <QuoteRadioButtons @filter="handleFilter"/>
            </div>

        </template>

        <div class="">
            <CoinTable @search="handleFilter" :coins="props.coins" :quote="props.filters.quote"/>
        </div>
    </AuthenticatedLayout>
</template>
