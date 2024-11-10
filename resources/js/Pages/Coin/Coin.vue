<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import QuoteRadioButtons from "@/Components/QuoteRadioButtons.vue";
import {throttle} from "lodash/function.js";
import LineChart from "@/Components/LineChart.vue";
import DropDownSelect from "@/Pages/Coin/Partials/DropDownSelect.vue";
import DataCard from "@/Pages/Coin/Partials/DataCard.vue";
import {ref} from "vue";

const props = defineProps({
    'coinPrices': Object,
})

const dropDownSelection = ref('price')

const handleDropDown = (filter) => {
    dropDownSelection.value = filter.dropdown
}

const handleFilter = throttle((filter) => {
    router.get(
        '/coin/' + props.coinPrices.id,
        {
            ...filter
        },
        {
            preserveState: true, replace: true,
            preserveScroll: true
        }
    )
}, 300)

const replaceByDefault = (e) => {
    e.target.src = 'storage/logos/btc-bitcoin.png'
}

const redirectBack = () => {
    window.history.back()
}
</script>

<template>
    <Head :title="coinPrices.name" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <button type="button" @click="redirectBack" class="relative inline-flex items-center px-2 py-2 text-sm 5xl:text-xl font-medium text-gray-400 bg-gray-800 rounded-lg hover:text-gray-300"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 20 20" class="w-7 h-7" aria-hidden="true" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"></path></svg> Back</button>
                <div class="flex items-center">
                    <img class="object-cover w-10 h-10 rounded-full" :src="'/storage/logos/'+ coinPrices.id + '.png'" @error="replaceByDefault" alt="">
                    <h2 class="ml-3 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ coinPrices.name }}</h2>
                </div>
                <QuoteRadioButtons @filter="handleFilter"/>
            </div>
        </template>

        <section class="container mx-auto">
            <div>
                <DataCard :coin="coinPrices"/>
            </div>
            <div class="min-h-fit w-3/4 mx-auto my-6 rounded-lg rounded-lg border border-solid dark:border-gray-600">
                <div class="">
                    <DropDownSelect @filter="handleDropDown"/>
                </div>
                <div class="relative min-h-[600px]">
                    <LineChart
                        :data="coinPrices.prices"
                        :id="'test'"
                        x="date"
                        :y="dropDownSelection"
                        :label=coinPrices.name
                    />
                </div>

            </div>
        </section>
    </AuthenticatedLayout>
</template>
