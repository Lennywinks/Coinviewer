<script setup>
    import {ref} from "vue";

    const selectedOption = ref('EUR')
    function getClass(option) {
        return this.selectedOption === option
        ? 'bg-indigo-600 text-white border-indigo-600'
        : 'text-gray-300 bg-gray-700 border-gray-600'
    }

    const emit = defineEmits(['filter'])

    const filter = (e) => {
        emit('filter', {'quote': e.target.value})
    };
</script>

<template>

    <div>
        <form class="flex space-x-2">
            <div>
                <input @click="filter" type="radio" id="option1" value="EUR" v-model="selectedOption" class="hidden" />
                <label
                    :class="getClass('EUR')"
                    for="option1"
                    class="cursor-pointer px-4 py-2 border-2 rounded-lg">
                    EUR
                </label>
            </div>

            <div>
                <input @click="filter" type="radio" id="option2" value="USD" v-model="selectedOption" class="hidden" />
                <label
                    :class="getClass('USD')"
                    for="option2"
                    class="cursor-pointer px-4 py-2 border-2 rounded-lg">
                    USD
                </label>
            </div>

            <div>
                <input @click="filter" type="radio" id="option3" value="BTC" v-model="selectedOption" class="hidden" />
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
