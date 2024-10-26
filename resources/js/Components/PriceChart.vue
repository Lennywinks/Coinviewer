<script setup>
    import {ref, watch, watchEffect} from 'vue';
    import { AgCharts } from 'ag-charts-vue3';

    const props = defineProps(['coinPrices'])

    const components = {
        'ag-charts': AgCharts,
    }
    const options = ref({
        data: props.coinPrices,
        series: [{ type: 'line', xKey: 'date', yKey: 'price' }],
        theme: 'ag-material-dark',
        background: {
            fill: '#1f2937'
        },
        animation: {
            enabled:true,
            duration: 500,
        }
    });

    watch(() => props.coinPrices, () => {
        options.value = {
            ...options.value,
            data: props.coinPrices
        };
    });
</script>

<template>
        <div class="bg-gray-800 rounded-md shadow-md p-6 rounded-lg max-w-xl w-full">
            <ag-charts :options="options" class="w-full h-96"></ag-charts>
        </div>
</template>
