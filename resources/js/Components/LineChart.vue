<script setup>
import Chart from "chart.js/auto";
import {computed, onMounted, watch} from "vue";

Chart.defaults.color = "#e5e7eb";

const props = defineProps({
    data: Array,
    id: String,
    x: String,
    y: String,
    label: String
})

const data = computed(() => props.data)
const y_axis = computed(() => props.y)

const renderChart = () => {
    console.log(y_axis)

    new Chart(
        document.getElementById(props.id),
        {
            type: 'line',
            data: {
                labels: data.value.map(row => row[props.x]),
                datasets: [
                    {
                        label: y_axis.value,
                        data: data.value.map(row => row[y_axis.value]),
                        // backgroundColor: '#4338ca',
                        // borderColor: '#4f46e5',
                        backgroundColor: 'rgba(67, 56, 202, 0.2)', // Halbtransparente Hintergrundfarbe
                        borderColor: '#4f46e5', // Linienfarbe
                        borderWidth: 2,
                        pointBackgroundColor: '#4f46e5', // Punktefarbe
                        pointBorderColor: '#4f46e5', // Rand der Punkte
                        pointHoverBackgroundColor: '#34D399', // Hover-Farbe für Punkte
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        border: {
                            display: false
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        grid: {
                            color: '#4b5563'
                        }
                    }
                }
            }
        }

    )
}

const updateChart = () => {
    const chart = Chart.getChart(props.id)
    chart.data.datasets[0].data = data.value.map(row => row[props.y])
    chart.data.datasets[0].label = y_axis.value
    chart.update()
}

onMounted(renderChart)

watch([data, y_axis], () => {
    updateChart()
})
</script>

<template>
    <canvas class="px-2 py-2" :id="props.id"></canvas>
</template>
