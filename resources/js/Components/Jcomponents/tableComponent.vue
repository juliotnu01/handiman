<script setup>
import { ref, defineProps, computed } from "vue";

const toggleMenuTable = ref(false);

const props = defineProps({
    headers: {
        type: Array,
        default: () => [],
        required: true,
    },
    items: {
        type: Array,
        default: () => [],
        required: true,
    },
    search: {
        type: String,
        default: '',
        required: false
    },
    search_by_index_value: {
        type: String,
        default: '',
        required: false
    }
});

const filterItems = computed(() => {
    return props.items.filter((elem) => {
        let _filter = String(props.search).toUpperCase();
        let _matchFilter = String(elem[props.search_by_index_value]).toUpperCase().includes(_filter);
        return _matchFilter;
    });
});

const getItemValue = (item, header) => {
    if (header.field && item[header.field] !== undefined) {
        return item[header.field];
    }
    return '';
};
</script>

<template>
    <section>
        <div class="p-10">
            <div class="flex justify-end my-2">
                <slot name="header"></slot>
            </div>
            <table class="table shadow-md bg-white rounded-xl w-full">
                <thead class="text-start border-b-[1px] border-b-[#cecece]">
                    <th class="p-3 text-gray-600 text-center " v-for="(header, h) in headers" :key="h">
                        <p class="self-center">
                            {{ header.text }}
                        </p>
                    </th>
                </thead>
                <tbody v-if="filterItems.length > 0">
                    <tr class="text-center border-b-[1px] border-b-[#cecece] hover:bg-gray-100"
                        v-for="(item, index) in filterItems" :key="index">
                        <td class="p-4" v-for="(header, key) in headers" :key="key">
                            <slot :name="header.field || key" :item="item" :value="getItemValue(item, header)">
                                {{ getItemValue(item, header) }}
                            </slot>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr class="text-center border-b-[1px] border-b-[#cecece] hover:bg-gray-100">
                        <td :colspan="headers.length">
                            <div class="flex bg-yellow-100 rounded-lg p-4 mb-4 text-sm text-yellow-700 m-4" role="alert">
                                <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <span class="font-medium">No hay datos!</span> 
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>