<template>
    <AppLayout title="Usuarios">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Usuarios</h2>
        </template>

        <div>
            <tableComponent :key="usuarios.current_page" :headers="headerUsuarios" :items="usuarios.data" :pagination="usuarios">
                <template #profile_photo_url="{ item }">
                    <div class="flex items-center space-x-3 min-w-[60px]" @click="ShowAvatar(item)">
                        <img :src="item.profile_photo_url" alt="Avatar"
                            class="w-14 h-14 rounded-full border border-gray-300 shadow-sm mx-auto cursor-pointer" />
                    </div>
                </template>

                <template #mode="{ item }">
                    <span class="px-4 py-1 rounded-full text-sm"
                        :class="item.mode === 1 ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600'">
                        {{ item.mode === 1 ? "Cliente" : "Especialista" }}
                    </span>
                </template>
            </tableComponent>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { usePage } from "@inertiajs/vue3";
import tableComponent from "@/Components/Jcomponents/tableComponent.vue";
import { ref, computed } from "vue";

const usuarios = computed(() => usePage().props.usuarios);

const headerUsuarios = ref([
    { text: "Nombre", field: "name" },
    { text: "Correo electrónico", field: "email" },
    { text: "Avatar", field: "profile_photo_url" },
    { text: "Modo", field: "mode" },
]);
</script>
