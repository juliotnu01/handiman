<template>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- Tabs para Roles y Permisos -->
            <div class="mb-4 border-b border-gray-200">
                <nav class="-mb-px flex">
                    <a @click="activeTab = 'roles'"
                        :class="[activeTab === 'roles' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm cursor-pointer']">
                        Roles
                    </a>
                    <a @click="activeTab = 'permissions'"
                        :class="[activeTab === 'permissions' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm cursor-pointer']">
                        Permisos
                    </a>
                </nav>
            </div>

            <!-- Contenido de Roles -->
            <div v-if="activeTab === 'roles'">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Crear Nuevo Rol</h2>
                    <form @submit.prevent="createRole" class="space-y-4">
                        <div>
                            <label for="newRoleName" class="block text-sm font-medium text-gray-700">Nombre del
                                Rol</label>
                            <input type="text" id="newRoleName" v-model="newRole.name" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Asignar Permisos</label>
                            <div class="grid grid-cols-3 gap-4">
                                <div v-for="permission in permissions" :key="permission.id" class="flex items-center">
                                    <input :id="'new-role-permission-' + permission.id" type="checkbox"
                                        v-model="newRole.permissions" :value="permission.id"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label :for="'new-role-permission-' + permission.id"
                                        class="ml-2 block text-sm text-gray-900">
                                        {{ permission.name }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Crear Rol
                        </button>
                    </form>
                </div>

                <div class="mt-10">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Roles Existentes</h2>
                    <div class="space-y-6">
                        <div v-for="role in roles" :key="role.id" class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ role.name }}</h3>
                                <button @click="deleteRole(role)"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Eliminar
                                </button>
                            </div>
                            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                                <dl class="sm:divide-y sm:divide-gray-200">
                                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">Permisos Asignados</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            <div class="grid grid-cols-2 gap-4">
                                                <div v-for="permission in permissions" :key="permission.id"
                                                    class="flex items-center">
                                                    <input :id="'role-permission-' + role.id + '-' + permission.id"
                                                        type="checkbox" v-model="role.permissions"
                                                        :value="permission.id" @change="updateRolePermissions(role)"
                                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                    <label :for="'role-permission-' + role.id + '-' + permission.id"
                                                        class="ml-2 block text-sm text-gray-900">
                                                        {{ permission.name }}
                                                    </label>
                                                </div>
                                            </div>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenido de Permisos -->
            <div v-if="activeTab === 'permissions'">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Crear Nuevo Permiso</h2>
                    <form @submit.prevent="createPermission" class="space-y-4">
                        <div>
                            <label for="newPermissionName" class="block text-sm font-medium text-gray-700">Nombre del
                                Permiso</label>
                            <input type="text" id="newPermissionName" v-model="newPermission" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Crear Permiso
                        </button>
                    </form>
                </div>

                <div class="mt-10">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Permisos Existentes</h2>
                    <ul class="divide-y divide-gray-200">
                        <li v-for="permission in permissions" :key="permission.id"
                            class="py-4 flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-900">{{ permission.name }}</span>
                            <button @click="deletePermission(permission)"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Eliminar
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps(['roles', 'permissions'])

const activeTab = ref('roles')
const newRole = ref({ name: '', permissions: [] })
const newPermission = ref('')

const rolesWithPermissions = computed(() => {
    return props.roles.map(role => ({
        ...role,
        permissions: role.permissions.map(p => p.id)
    }))
})

const createRole = () => {
    useForm(newRole.value).post(route('roles.store'), {
        preserveState: false,
        preserveScroll: true,
        onSuccess: () => {
            newRole.value = { name: '', permissions: [] }
        },
    })
}

const updateRolePermissions = (role) => {
    useForm({
        permissions: role.permissions
    }).put(route('roles.update', role.id), {
        preserveState: true,
        preserveScroll: true,
    })
}

const deleteRole = (role) => {
    if (confirm('¿Estás seguro de que quieres eliminar este rol?')) {
        useForm().delete(route('roles.delete', role.id), {
            preserveState: false,
            preserveScroll: true,
        })
    }
}

const createPermission = () => {
    useForm({ name: newPermission.value }).post(route('permissions.store'), {
        preserveState: false,
        preserveScroll: true,
        onSuccess: () => newPermission.value = '',
    })
}

const deletePermission = (permission) => {
    if (confirm('¿Estás seguro de que quieres eliminar este permiso?')) {
        useForm().delete(route('permissions.delete', permission.id), {
            preserveState: false,
            preserveScroll: true,
        })
    }
}
</script>