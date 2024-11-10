<script setup>
import {useForm} from "@inertiajs/vue3";
import SearchDropDown from "@/Components/SearchDropDown.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
    coins: Array,
})

const form = useForm({
    coin_id: null,
    amount: null
})

const handleSelection = (selection) => {
    form.coin_id = selection.id
}
</script>

<template>
    <form @submit.prevent="form.post('/portfolio')" class="p-4">
        <div class="flex items-center">
            <SearchDropDown
                :options="coins"
                @selected="handleSelection"
                :disabled="false"
                placeholder="Select a Coin"
                v-model="form.coin_id"
            />
            <input
                class="mx-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                v-model="form.amount"
                placeholder="Enter Amount of Coins"
            />
            <PrimaryButton type="submit" :disabled="form.processing">Add</PrimaryButton>
        </div>
        <div v-if="form.errors.coin_id" class="text-red-500">{{ form.errors.coin_id }}</div>
        <div v-if="form.errors.amount" class="text-red-500">{{ form.errors.amount }}</div>
    </form>
</template>
