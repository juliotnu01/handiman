<script setup  >
import { ref, defineProps } from "vue";

const toggleMenu = ref(false);

defineProps({
    options: {
        // type: { text: '', value: '' },
        default:[],
        required: true
    }
})

</script>

<template>
    <section class="p-4 "  @click="toggleMenu = !toggleMenu">
        <div class="flex items-center flex-col gap-1  hover:bg-[#e2dfdf] w-fit h-fit p-2 cursor-pointer rounded-full active:bg-gray-200 relative">
            <div class="w-[5px] h-[5px] bg-black rounded-full"></div>
            <div class="w-[5px] h-[5px] bg-black rounded-full"></div>
            <div class="w-[5px] h-[5px] bg-black rounded-full"></div>
            <div :class="{
                'absolute z-[100] bg-white shadow-2xl right-[1rem]  top-7  p-3  rounded-xl border-[1px] border-[#cecece]  w-fit': toggleMenu,
                'absolute z-[100] bg-white shadow-2xl right-[1rem] top-12  p-3  rounded-xl border-[1px] border-[#cecece] hidden w-fit ': !toggleMenu
            }">
                <ul>
                    <li v-for="(option, o) in options" :key="o" class="text-center align-middle justify-center py-2 whitespace-nowrap  flex " >
                        <slot class="text-center" :name="option.text" :item="option.text" @click="toggleMenu = !toggleMenu">{{ option.value }}</slot>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</template>