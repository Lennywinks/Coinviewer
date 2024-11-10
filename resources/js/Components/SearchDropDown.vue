<!--https://github.com/romainsimon/vue-simple-search-dropdown-->
<script>
export default {
    name: 'SearchDropDown',
    template: 'SearchDropDown',
    props: {
        name: {
            type: String,
            required: false,
            default: 'dropdown',
            note: 'Input name'
        },
        options: {
            type: Array,
            required: true,
            default: [],
            note: 'Options of dropdown. An array of options with id and name',
        },
        placeholder: {
            type: String,
            required: false,
            default: 'Please select an option',
            note: 'Placeholder of dropdown'
        },
        disabled: {
            type: Boolean,
            required: false,
            default: false,
            note: 'Disable the dropdown'
        },
        maxItem: {
            type: Number,
            required: false,
            default: 6,
            note: 'Max items showing'
        }
    },
    data() {
        return {
            selected: {},
            optionsShown: false,
            searchFilter: ''
        }
    },
    created() {
        this.$emit('selected', this.selected);
    },
    computed: {
        filteredOptions() {
            const filtered = [];
            const regOption = new RegExp(this.searchFilter, 'ig');
            for (const option of this.options) {
                if (this.searchFilter.length < 1 || option.name.match(regOption)){
                    if (filtered.length < this.maxItem) filtered.push(option);
                }
            }
            return filtered;
        }
    },
    methods: {
        selectOption(option) {
            this.selected = option;
            this.optionsShown = false;
            this.searchFilter = this.selected.name;
            this.$emit('selected', this.selected);
        },
        showOptions(){
            if (!this.disabled) {
                this.searchFilter = '';
                this.optionsShown = true;
            }
        },
        exit() {
            if (!this.selected.id) {
                this.selected = {};
                this.searchFilter = '';
            } else {
                this.searchFilter = this.selected.name;
            }
            // this.$emit('selected', this.selected);
            this.optionsShown = false;
        },
        // Selecting when pressing Enter
        keyMonitor: function(event) {
            if (event.key === "Enter" && this.filteredOptions[0])
                this.selectOption(this.filteredOptions[0]);
        }
    },
    watch: {
        searchFilter() {
            if (this.filteredOptions.length === 0) {
                this.selected = {};
            } else {
                this.selected = this.filteredOptions[0];
            }
            this.$emit('filter', this.searchFilter);
        }
    }
};
</script>

<template>
    <div class="dropdown" v-if="options">

        <!-- Dropdown Input -->
        <input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm cursor-pointer"
               :name="name"
               @focus="showOptions()"
               @blur="exit()"
               @keyup="keyMonitor"
               v-model="searchFilter"
               :disabled="disabled"
               :placeholder="placeholder" />

        <!-- Dropdown Menu -->
        <div class="absolute min-w-[248px] max-w-[248px] max-h-[248px] hover:block border-gray-300 dark:border-gray-500 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm cursor-pointer"
             v-show="optionsShown">
            <div
                class="hover:bg-gray-700"
                @mousedown="selectOption(option)"
                v-for="(option, index) in filteredOptions"
                :key="index">
                {{ option.name || option.id || '-' }}
            </div>
        </div>
    </div>
</template>
