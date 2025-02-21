<script setup>
import { defineProps, computed } from "vue";
import { usePage, router } from "@inertiajs/vue3";

const props = defineProps({
    headers: Array,
    items: Array,
    pagination: Object,
});

const getItemValue = (item, header) => {
    return header.field && item[header.field] !== undefined ? item[header.field] : "";
};

const changePage = (url) => {
    if (url) {
        router.get(url, {}, { preserveState: false, preserveScroll: true });
    }
};
</script>

<template>
    <section>
        <div class="p-10">
            <div class="flex justify-end my-2">
                <slot name="header"></slot>
            </div>
            <!-- PAGINACIÓN -->
            <div v-if="pagination && pagination.links.length > 3" class="flex justify-center mb-4 space-x-2">
                <button v-for="(link, index) in pagination.links" :key="index" @click="changePage(link.url)"
                    v-html="link.label" class="px-4 py-2 border rounded-md" :class="{
                        'bg-blue-500 text-white': link.active,
                        'text-gray-500 cursor-not-allowed': !link.url,
                    }" :disabled="!link.url"></button>
            </div>
            <table class="table shadow-md bg-white rounded-xl w-full">
                <thead class="text-start border-b-[1px] border-b-[#cecece]">
                    <tr>
                        <th class="p-3 text-gray-600 text-center" v-for="(header, h) in headers" :key="h">
                            <p class="self-center">
                                {{ header.text }}
                            </p>
                        </th>
                    </tr>
                </thead>

                <tbody v-if="items.length > 0">
                    <tr class="text-center border-b-[1px] border-b-[#cecece] hover:bg-gray-100"
                        v-for="(item, index) in items" :key="index">
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
                            <div class="flex bg-yellow-100 rounded-lg p-4 text-sm text-yellow-700 m-4" role="alert">
                                <span class="font-medium">No hay datos!</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>
