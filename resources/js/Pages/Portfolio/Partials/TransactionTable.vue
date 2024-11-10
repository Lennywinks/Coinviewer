<script setup>
import {usePage} from "@inertiajs/vue3";

const page = usePage()

const props = defineProps({
    transactions: Array
})

const getCurrentPrice = (prices) => {
    const test = prices.filter((price) => price.quote === page.props.selectedQuote)
    return test.slice(-1)[0].price
}

const replaceByDefault = (e) => {
    e.target.src = 'storage/logos/btc-bitcoin.png'
}

const symbols = {
    "EUR": "€",
    "USD": "$",
    "BTC": "BTC"
}
</script>

<template>
    <div class="mt-6 w-2/5">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-scroll border border-gray-200 dark:border-gray-700 md:rounded-lg max-h-[500px]">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800 top-0 sticky">
                        <tr>
                            <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <div class="flex items-center gap-x-3">
                                    <span>Rank / Coin</span>
                                </div>
                            </th>

                            <th scope="col" class="px-3.5 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <button class="flex items-center gap-x-2">
                                    <span>Price</span>
                                </button>
                            </th>

                            <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <button class="flex items-center gap-x-2">
                                    <span>Stocks</span>
                                </button>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                        <tr v-for="transaction in transactions">
                            <td class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                                <div class="inline-flex items-center gap-x-3">
                                    <div class="text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">{{ transaction.coin.rank }}</div>

                                    <div class="flex items-center gap-x-2">
                                        <img class="object-cover w-10 h-10 rounded-full" :src="'/storage/logos/'+ transaction.coin.id + '.png'" @error="replaceByDefault" alt="">
                                        <div>
                                            <h2 class="font-medium text-gray-800 dark:text-white ">{{ transaction.coin.symbol }}</h2>
                                            <p class="text-sm font-normal text-gray-600 dark:text-gray-400">{{ transaction.coin.name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td v-if="page.props.selectedQuote === 'BTC'" class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap font-semibold">{{ Math.round(getCurrentPrice(transaction.coin.prices) * 100000000) / 100000000 + ' ' + symbols[page.props.selectedQuote] }}</td>
                            <td v-else class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap font-semibold">{{ Math.round(getCurrentPrice(transaction.coin.prices) * 100) / 100 + ' ' + symbols[page.props.selectedQuote] }}</td>
                            <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap font-semibold">{{ parseFloat(transaction.amount) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

