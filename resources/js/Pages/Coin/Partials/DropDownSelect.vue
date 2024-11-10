<script setup>

const props = defineProps({
    options: Array
})



const emit = defineEmits(['filter'])

const filter = (e) => {
    emit('filter', {'dropdown': e.target.value})
}
</script>

<template>
    <form class="max-w-sm mx-auto py-2">
        <select id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
            <option selected @click="filter" value="price">Price</option>
            <option @click="filter" value="volume_24h">Volume 24h</option>
            <option @click="filter" value="ath_price">ATH Price</option>
        </select>
    </form>
</template>
