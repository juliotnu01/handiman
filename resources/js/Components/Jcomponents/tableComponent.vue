<script setup  >

import { ref, defineProps } from "vue";

const toggleMenuTable = ref(false);

defineProps({
    headers: {
        // type: {
        //     text: '',
        //     value: '',
        //     align: 'start' | 'center' | 'end',
        //     sortable: false,
        // },
        default: [],
        required: true,
    },
    items: {
        type: Array,
        default: [],
        required: true,
    }
})

</script>

<template>
    <section>
        <div class="p-10 ">
            <table class="table shadow-md bg-white  rounded-xl  ">
                <thead class="text-start  border-b-[1px] border-b-[#cecece]   ">
                    <th class="p-3  text-gray-600 " v-for="(header, h) in headers" :key="h">
                        <p class=" self-center ">
                            {{ header.text }}
                        </p>
                    </th>
                </thead>
                <tbody>
                    <tr class=" text-center border-b-[1px] border-b-[#cecece] hover:bg-gray-100"
                        v-for="(item, index) in items" :key="index">
                        <td class="p-4" v-for="(value, key) in item" :key="key">
                            <slot :name="key" :item="item">{{ value }}</slot>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>