<script setup>
    import SearchBox from "@/Components/SearchBox.vue";
    import {Link, usePage} from '@inertiajs/vue3';

    const page = usePage()

    defineProps({
        coins: Object,
    })

    const emit = defineEmits(['search'])
    const handleSearch = (e) => {
        console.log(e)
        emit('search', {'search': e})
    };

    const symbols = {
        "EUR": "€",
        "USD": "$",
        "BTC": "BTC"
    }

    function nFormatter(num, digits) {
        const lookup = [
            { value: 1, symbol: "" },
            { value: 1e3, symbol: "k" },
            { value: 1e6, symbol: "M" },
            { value: 1e9, symbol: "B" },
            { value: 1e12, symbol: "T" },
            { value: 1e15, symbol: "P" },
            { value: 1e18, symbol: "E" }
        ];
        const regexp = /\.0+$|(?<=\.[0-9]*[1-9])0+$/;
        const item = lookup.findLast(item => num >= item.value);
        return item ? (num / item.value).toFixed(digits).replace(regexp, "").concat(item.symbol) : "0";
    }

    const replaceByDefault = (e) => {
        e.target.src = 'storage/logos/btc-bitcoin.png'
    }
</script>

<template>
    <section class="containerv mx-auto">
        <div class="flex flex-col mt-6 w-3/4 mx-auto">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center gap-x-3">
                                        <span>Name</span>
                                        <span>
                                            <SearchBox @search="handleSearch"/>
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-3.5 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <button class="flex items-center gap-x-2">
                                        <span>Price</span>
                                    </button>
                                </th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <button class="flex items-center gap-x-2">
                                        <span>Market Cap</span>
                                    </button>
                                </th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">24h %</th>

                                <th scope="col" class="relative py-3.5 px-4">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                            <tr v-for="coin in coins.data">
                                <td class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                                    <Link :href="route('coin.show', {id: coin.id, _query: {'quote': page.props.selectedQuote}})" preserve-state class="inline-flex items-center gap-x-3">
                                        <div class="text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">{{ coin.rank }}</div>

                                        <div class="flex items-center gap-x-2">
                                            <img class="object-cover w-10 h-10 rounded-full" :src="'/storage/logos/'+ coin.id + '.png'" @error="replaceByDefault" alt="">
                                            <div>
                                                <h2 class="font-medium text-gray-800 dark:text-white ">{{ coin.symbol }}</h2>
                                                <p class="text-sm font-normal text-gray-600 dark:text-gray-400">{{ coin.name }}</p>
                                            </div>
                                        </div>
                                    </Link>
                                </td>
                                <td v-if="page.props.selectedQuote === 'BTC'" class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap font-semibold">{{ symbols[page.props.selectedQuote] + " " + coin.current_price.price.toFixed(8) }}</td>
                                <td v-else class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap font-semibold">{{ symbols[page.props.selectedQuote] + " " + coin.current_price.price.toFixed(2) }}</td>
                                <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap font-semibold">{{ symbols[page.props.selectedQuote] + " " + nFormatter(coin.current_price.market_cap) }}</td>
                                <td class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                                    <div class="inline-flex items-center px-3 py-1 rounded-full gap-x-2 bg-emerald-100/60 dark:bg-gray-800">
                                        <span v-if="coin.current_price.price_change_24h < 0" class="w-1.5 h-1.5 border-l-[5px] border-l-transparent border-t-[5px] border-t-rose-500 border-r-[5px] border-r-transparent"></span>
                                        <span v-if="coin.current_price.price_change_24h >= 0" class="w-0 h-0 border-l-[5px] border-l-transparent border-b-[5px] border-b-emerald-500 border-r-[5px] border-r-transparent"></span>

                                        <h2 v-if="coin.current_price.price_change_24h < 0" class="text-sm font-normal text-rose-500">{{ Math.round(coin.current_price.price_change_24h * 100) / 100  + "%" }}</h2>
                                        <h2 v-if="coin.current_price.price_change_24h >= 0" class="text-sm font-normal text-emerald-500">{{ Math.round(coin.current_price.price_change_24h * 100) / 100  + "%" }}</h2>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between mt-6 w-3/4 mx-auto">
            <template v-for="link in coins.links">
                <Component
                    :is="link.url ? Link : 'div'"
                    v-if="link.label.includes('Previous')"
                    :href="link.url"
                    class="flex items-center px-5 py-2 text-sm capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 dark:bg-gray-900 dark:border-gray-700"
                    :class="link.url ? 'text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800' : 'text-gray-500 dark:text-gray-700'"
                    preserve-state
                    preserve-scroll
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 rtl:-scale-x-100">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                    </svg>

                    <span>
                        previous
                    </span>
                </Component>

                <div v-else-if="!link.label.includes('Next')" class="items-center hidden lg:flex gap-x-3">
                    <Component
                        :is="link.url ? Link : 'div'"
                        :href="link.url"
                        v-html="link.label"
                        class="px-4 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2  dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700"
                        :class="[link.active ? 'dark:border-indigo-600 ' : '', link.url ? 'hover:bg-gray-100 dark:hover:bg-gray-800': ' ']"
                        preserve-state
                        preserve-scroll
                    />
                </div>

                <Component
                    :is="link.url ? Link : 'div'"
                    v-else
                    :href="link.url"
                    class="flex items-center px-5 py-2 text-sm capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 dark:bg-gray-900 dark:border-gray-700"
                    :class="link.url ? 'text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800' : 'text-gray-500 dark:text-gray-700'"
                    preserve-state
                    preserve-scroll
                >
                    <span>
                        Next
                    </span>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 rtl:-scale-x-100">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                    </svg>
                </Component>
            </template>
        </div>
    </section>
</template>
