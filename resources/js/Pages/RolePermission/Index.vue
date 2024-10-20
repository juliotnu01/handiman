<template>
    <AppLayout title="Gestión de Roles y Permisos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gestión de Roles y Permisos
            </h2>
        </template>

        <RolesAndPermissionsComponent :roles="roles" :permissions="permissions" />
    </AppLayout>
</template>

<script setup>
import { defineProps, ref, onMounted } from 'vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import RolesAndPermissionsComponent from "@/Components/Jcomponents/RolesAndPermissions.vue";

const roles = ref([]);
const permissions = ref([]);
const getRolesYPermisos = async () => {
    try {
        let { data } = await axios(route('get.roles.permissions'))
        roles.value = data.roles
        permissions.value = data.permissions
    } catch (error) {
        console.log(error);
        
    }
} 

onMounted(() => {
    getRolesYPermisos()
})


</script>