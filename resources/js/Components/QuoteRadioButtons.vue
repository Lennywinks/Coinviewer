<script setup>

    import {ref} from "vue";
    import { router } from '@inertiajs/vue3'

    const selectedOption = ref('EUR')
    function getClass(option) {
        return this.selectedOption === option
        ? 'bg-blue-600 text-white border-blue-600'
        : 'text-gray-700 bg-white border-gray-300'
    }

    function applyFilter(option) {
        router.get('/overview',
            {'quote': option},
            {preserveState: true}
        )
    }
</script>

<template>

    <div>
        <form class="flex space-x-2">
            <div>
                <input @click="applyFilter('EUR')" type="radio" id="option1" value="EUR" v-model="selectedOption" class="hidden" />
                <label
                    :class="getClass('EUR')"
                    for="option1"
                    class="cursor-pointer px-4 py-2 border-2 rounded-lg">
                    EUR
                </label>
            </div>

            <div>
                <input @click="applyFilter('USD')" type="radio" id="option2" value="USD" v-model="selectedOption" class="hidden" />
                <label
                    :class="getClass('USD')"
                    for="option2"
                    class="cursor-pointer px-4 py-2 border-2 rounded-lg">
                    USD
                </label>
            </div>

            <div>
                <input @click="applyFilter('BTC')" type="radio" id="option3" value="BTC" v-model="selectedOption" class="hidden" />
                <label
                    :class="getClass('BTC')"
                    for="option3"
                    class="cursor-pointer px-4 py-2 border-2 rounded-lg">
                    BTC
                </label>
            </div>
        </form>
    </div>
</template>
