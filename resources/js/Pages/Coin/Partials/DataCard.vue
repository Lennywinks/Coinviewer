<script setup>
const props = defineProps({
    'coin': Object
})


</script>

<template>


    <div class="container w-3/4 mx-auto mt-6 border border-gray-200 rounded-lg dark:border-gray-600">
        <div class="border-gray-200 dark:border-gray-600">
            <div class="p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="stats" role="tabpanel" aria-labelledby="stats-tab">
                <dl class="flex justify-between max-w-screen-xl gap-8 p-4 mx-auto text-gray-900 dark:text-gray-200 sm:p-8">
                    <div class="flex flex-col items-center justify-center">
                        <dd class="text-gray-500 dark:text-gray-400">Rank</dd>
                        <dt class="mt-2 text-3xl font-extrabold">{{ props.coin.rank }}</dt>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <dd class="text-gray-500 dark:text-gray-400">Total Supply</dd>
                        <dt class="mt-2 text-3xl font-extrabold">{{ props.coin.total_supply }}</dt>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <dd class="text-gray-500 dark:text-gray-400">Max Supply</dd>
                        <dt class="mt-2 text-3xl font-extrabold">{{ props.coin.max_supply === 0 ? "∞" : props.coin.max_supply}}</dt>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <dd class="text-gray-500 dark:text-gray-400">Beta Value</dd>
                        <dt class="mt-2 text-3xl font-extrabold">{{ Math.round(props.coin.beta_value * 100) / 100 }}</dt>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</template>
