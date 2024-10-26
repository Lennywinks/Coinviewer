<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PriceChart from "@/Components/PriceChart.vue";
import QuoteRadioButtons from "@/Components/QuoteRadioButtons.vue";
import CoinTable from "@/Pages/Overview/Partials/CoinTable.vue";

defineProps(["quote", "coinPrices", "coins"])
</script>

<template>
    <Head title="Overview" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Overview</h2>
                <QuoteRadioButtons/>
            </div>

        </template>

        <div class="">
<!--            <PriceChart :coin-prices="coinPrices"/>-->
            <CoinTable :coins="coins" :quote="quote"/>
        </div>
        <li v-for="coinPrice in coinPrices"> {{ coinPrice }}</li>
    </AuthenticatedLayout>
</template>
