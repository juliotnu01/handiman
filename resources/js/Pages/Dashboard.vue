<script setup  >
import AppLayout from "@/Layouts/AppLayout.vue";
import tableComponent from "@/Components/Jcomponents/tableComponent.vue";
import selectMenuComponent from "@/Components/Jcomponents/selectMenuComponent.vue";
import { ref } from "vue";

const headers = ref([
    { text: ' #', },
    { text: ' Código servicio', },
    { text: 'Servicio', },
    { text: 'Tipo servicio', },
    { text: 'Ubicación', },
    { text: 'Coordenadas', },
    { text: ' Estado servicio', },
    { text: 'Precio servicio', },
    { text: 'Usuario creador', },
    { text: 'Usuario Solicitante', },
    { text: ' Acción', },
]);

const items  = ref([
    {
        id: '1',
        codigo: '5346f9e0-7ee0-11ee-b962-0242ac120002',
        servicio: 'Lorem ipsum dolor sit amet consectetur adipisicing elit',
        tipo_servicio: 'Lorem ipsum dolor',
        ubicacion: '5402 Margaretta Stravenue, Deonberg, IA 05039-8529',
        coordenadas: '26.65195, 56.36255',
        status: 1,
        precio: '999.999,99',
        usr_creador: 'asdasd',
        usr_solicitante: 'asdasd',
        accion: 'asdas',
    },
])

const options = ref([
    {
        text: 'opcion_1',
        value: 'opcion 1',
    },
    {
        text: 'opcion_2',
        value: 'opcion 2',
    },
    {
        text: 'opcion_3',
        value: 'opcion 3',
    },

])



</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class=" mx-auto">
                <tableComponent :headers="headers" :items="items">
                    <template v-slot:precio="{ item }">
                        <p class="font-bold text-[17px] text-green-400 whitespace-nowrap">
                            $ {{ item.precio }}
                        </p>
                    </template>
                    <template v-slot:status="{ item }">
                        <div :class="{
                            'center animate-pulse relative inline-block select-none whitespace-nowrap rounded-lg bg-green-500 py-2 px-3.5 align-baseline font-sans text-xs font-bold uppercase leading-none text-white': item.status == 1,
                            'center animate-pulse relative inline-block select-none whitespace-nowrap rounded-lg bg-red-500 py-2 px-3.5 align-baseline font-sans text-xs font-bold uppercase leading-none text-white': item.status == 0
                        }">
                            <div class="mt-px">{{ item.status == 1 ? 'Activo' : 'Desactivado' }}</div>
                        </div>
                    </template>
                    <template v-slot:usr_creador="{ item }">
                        <div class="flex items-center flex-col">
                            <img src="https://randomuser.me/api/portraits/women/11.jpg" alt=""
                                class="rounded-full w-16 h-16 object-cover" />
                            <h5 class="font-semibold">{{ item.usr_creador }}</h5>
                        </div>
                    </template>
                    <template v-slot:usr_solicitante="{ item }">
                        <div class="flex items-center flex-col">
                            <img src="https://randomuser.me/api/portraits/women/28.jpg" alt=""
                                class="rounded-full w-16 h-16 object-cover" />
                            <h5 class="font-semibold">{{ item.usr_solicitante }}</h5>
                        </div>
                    </template>
                    <template v-slot:accion>
                        <selectMenuComponent :options="options">
                            <template v-slot:opcion_1>
                                <svg width="25px"
                                    class="text-blue-500 cursor-pointer active:bg-blue-200 w-fit h-fit rounded-full"
                                    height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12 8.25C9.92893 8.25 8.25 9.92893 8.25 12C8.25 14.0711 9.92893 15.75 12 15.75C14.0711 15.75 15.75 14.0711 15.75 12C15.75 9.92893 14.0711 8.25 12 8.25ZM9.75 12C9.75 10.7574 10.7574 9.75 12 9.75C13.2426 9.75 14.25 10.7574 14.25 12C14.25 13.2426 13.2426 14.25 12 14.25C10.7574 14.25 9.75 13.2426 9.75 12Z"
                                        fill="currentColor" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12 3.25C7.48587 3.25 4.44529 5.9542 2.68057 8.24686L2.64874 8.2882C2.24964 8.80653 1.88206 9.28392 1.63269 9.8484C1.36564 10.4529 1.25 11.1117 1.25 12C1.25 12.8883 1.36564 13.5471 1.63269 14.1516C1.88206 14.7161 2.24964 15.1935 2.64875 15.7118L2.68057 15.7531C4.44529 18.0458 7.48587 20.75 12 20.75C16.5141 20.75 19.5547 18.0458 21.3194 15.7531L21.3512 15.7118C21.7504 15.1935 22.1179 14.7161 22.3673 14.1516C22.6344 13.5471 22.75 12.8883 22.75 12C22.75 11.1117 22.6344 10.4529 22.3673 9.8484C22.1179 9.28391 21.7504 8.80652 21.3512 8.28818L21.3194 8.24686C19.5547 5.9542 16.5141 3.25 12 3.25ZM3.86922 9.1618C5.49864 7.04492 8.15036 4.75 12 4.75C15.8496 4.75 18.5014 7.04492 20.1308 9.1618C20.5694 9.73159 20.8263 10.0721 20.9952 10.4545C21.1532 10.812 21.25 11.2489 21.25 12C21.25 12.7511 21.1532 13.188 20.9952 13.5455C20.8263 13.9279 20.5694 14.2684 20.1308 14.8382C18.5014 16.9551 15.8496 19.25 12 19.25C8.15036 19.25 5.49864 16.9551 3.86922 14.8382C3.43064 14.2684 3.17374 13.9279 3.00476 13.5455C2.84684 13.188 2.75 12.7511 2.75 12C2.75 11.2489 2.84684 10.812 3.00476 10.4545C3.17374 10.0721 3.43063 9.73159 3.86922 9.1618Z"
                                        fill="currentColor" />
                                </svg>
                            </template>
                            <template v-slot:opcion_2>
                                <svg width="25px" height="25px"
                                    class="text-yellow-500 cursor-pointer active:bg-yellow-200 w-fit h-fit rounded-full"
                                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M16.04 3.02001L8.16 10.9C7.86 11.2 7.56 11.79 7.5 12.22L7.07 15.23C6.91 16.32 7.68 17.08 8.77 16.93L11.78 16.5C12.2 16.44 12.79 16.14 13.1 15.84L20.98 7.96001C22.34 6.60001 22.98 5.02001 20.98 3.02001C18.98 1.02001 17.4 1.66001 16.04 3.02001Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M14.91 4.1499C15.58 6.5399 17.45 8.4099 19.85 9.0899" stroke="currentColor"
                                        stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </template>
                            <template v-slot:opcion_3>
                                <svg width="25px"
                                    class="text-red-500 cursor-pointer active:bg-red-200 w-fit h-fit rounded-full"
                                    height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.1709 4C9.58273 2.83481 10.694 2 12.0002 2C13.3064 2 14.4177 2.83481 14.8295 4"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M20.5001 6H3.5" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" />
                                    <path
                                        d="M18.8332 8.5L18.3732 15.3991C18.1962 18.054 18.1077 19.3815 17.2427 20.1907C16.3777 21 15.0473 21 12.3865 21H11.6132C8.95235 21 7.62195 21 6.75694 20.1907C5.89194 19.3815 5.80344 18.054 5.62644 15.3991L5.1665 8.5"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M9.5 11L10 16" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" />
                                    <path d="M14.5 11L14 16" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" />
                                </svg>
                            </template>
                        </selectMenuComponent>
                    </template>
                </tableComponent>
            </div>
        </div>
    </AppLayout>
</template>
