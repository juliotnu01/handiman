<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import tableComponent from "@/Components/Jcomponents/tableComponent.vue";
import SelectComponent from "@/Components/Jcomponents/selectMenuComponent.vue";
import DialogComponent from "@/Components/DialogModal.vue";
import { ref, onMounted } from "vue";


const showModalServicios = ref(false)
const showModalDocumentos = ref(false)
const showSpingRevision = ref(false)
const showModalIdentificacion = ref(false)
const showModalAvatar = ref(false)
const IDSHOW = ref({
    front: '',
    back: ''
})
const AVATARSHOW = ref('')
const documentos = ref([])
const serviciosPrestados = ref([])

const headerEspecialistas = ref([
    { text: '' },
    { text: 'Nombre', field: 'nombre' },
    { text: 'Apellido', field: 'apellido' },
    { text: 'Identificación', field: 'numero_identificacion' },
    { text: 'Fecha Nacimiento', field: 'fecha_nacimiento' },
    { text: 'Correo', field: 'correo' },
    { text: 'Status', field: 'status' },
    { text: 'Revision', field: 'revision' },
    { text: 'Activacion', field: 'id' },
    { text: 'Certificados', },
    { text: 'Servicios prestados', field: 'servicios' },
]);

const especialistas = ref([]);

const getEspecialistasData = async () => {
    try {
        let { data } = await axios(route('get.especialistas'))
        for (const element of data) {
            element.showSpingRevision = false
            element.showSpingStatus = false
        }

        especialistas.value = data
    } catch (error) {
        console.log({ error });

    }
}

const ShowIdentificacion = (id) => {
    IDSHOW.value.front = id.url_documento_identificacion_frontal
    IDSHOW.value.back = id.url_documento_identificacion_trasera
    showModalIdentificacion.value = true
}
const ShowAvatar = (id) => {
    AVATARSHOW.value = id.url_avatar
    showModalAvatar.value = true
}
const ShowDocumentos = (id) => {
    documentos.value = id.certificados
    showModalDocumentos.value = true
}
const isImage = (url) => {
    const imageExtensions = ['jpg', 'jpeg', 'png'];
    const extension = url.split('.').pop().toLowerCase();
    return imageExtensions.includes(extension);
};
const switchValue = ref(0);
const isChecked = ref(switchValue.value === 1);
const toggleSwitch = async (id, status) => {
    try {
        id.showSpingStatus = true
        await axios.put(route('update.status.especialistas', { id: id }), { status: status })
        getEspecialistasData()
        id.showSpingStatus = false
    } catch (error) {
        console.log({ error });

    }
};
const toggleSwitchRevision = async (id, status) => {
    try {
        id.showSpingRevision = true
        await axios.put(route('update.revision.especialistas', { id: id }), { revision: status })
        getEspecialistasData()
        id.showSpingRevision = false
    } catch (error) {
        console.log({ error });

    }
};
const toggleServiciosPrestados = async (servicios) => {
    showModalServicios.value = true
    serviciosPrestados.value = servicios
};
onMounted(() => {
    getEspecialistasData()
})

</script>
<template>
    <AppLayout title="Especialistas">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Especialistas
            </h2>
        </template>
        <div>
            <tableComponent :headers="headerEspecialistas" :items="especialistas">
                <template #0="{ item }">
                    <div class="flex items-center space-x-3 min-w-[60px]" @click="ShowAvatar(item)">
                        <img :src="item.url_avatar" alt="Avatar"
                            class="w-14 h-14  rounded-full border border-gray-300 shadow-sm mx-auto cursor-pointer " />
                    </div>
                </template>
                <template #nombre="{ value }">
                    <p class="font-bold">{{ value }}</p>
                </template>
                <template #status="{ item }">
                    <span :class="[
                        'px-4 py-1 rounded-full text-sm font-semibold',
                        item.status === 1 ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'
                    ]">
                        {{ item.status === 1 ? 'Activo' : 'Desactivado' }}
                    </span>
                </template>
                <template #numero_identificacion="{ item, value }">
                    <div class="  w-22 items-center    mx-auto  ">
                        <div class="flex gap-2 justify-between">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                class="self-center text-purple-600 cursor-pointer " @click="ShowIdentificacion(item)">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12 8.25C9.92893 8.25 8.25 9.92893 8.25 12C8.25 14.0711 9.92893 15.75 12 15.75C14.0711 15.75 15.75 14.0711 15.75 12C15.75 9.92893 14.0711 8.25 12 8.25ZM9.75 12C9.75 10.7574 10.7574 9.75 12 9.75C13.2426 9.75 14.25 10.7574 14.25 12C14.25 13.2426 13.2426 14.25 12 14.25C10.7574 14.25 9.75 13.2426 9.75 12Z"
                                    fill="currentColor" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12 3.25C7.48587 3.25 4.44529 5.9542 2.68057 8.24686L2.64874 8.2882C2.24964 8.80653 1.88206 9.28392 1.63269 9.8484C1.36564 10.4529 1.25 11.1117 1.25 12C1.25 12.8883 1.36564 13.5471 1.63269 14.1516C1.88206 14.7161 2.24964 15.1935 2.64875 15.7118L2.68057 15.7531C4.44529 18.0458 7.48587 20.75 12 20.75C16.5141 20.75 19.5547 18.0458 21.3194 15.7531L21.3512 15.7118C21.7504 15.1935 22.1179 14.7161 22.3673 14.1516C22.6344 13.5471 22.75 12.8883 22.75 12C22.75 11.1117 22.6344 10.4529 22.3673 9.8484C22.1179 9.28391 21.7504 8.80652 21.3512 8.28818L21.3194 8.24686C19.5547 5.9542 16.5141 3.25 12 3.25ZM3.86922 9.1618C5.49864 7.04492 8.15036 4.75 12 4.75C15.8496 4.75 18.5014 7.04492 20.1308 9.1618C20.5694 9.73159 20.8263 10.0721 20.9952 10.4545C21.1532 10.812 21.25 11.2489 21.25 12C21.25 12.7511 21.1532 13.188 20.9952 13.5455C20.8263 13.9279 20.5694 14.2684 20.1308 14.8382C18.5014 16.9551 15.8496 19.25 12 19.25C8.15036 19.25 5.49864 16.9551 3.86922 14.8382C3.43064 14.2684 3.17374 13.9279 3.00476 13.5455C2.84684 13.188 2.75 12.7511 2.75 12C2.75 11.2489 2.84684 10.812 3.00476 10.4545C3.17374 10.0721 3.43063 9.73159 3.86922 9.1618Z"
                                    fill="currentColor" />
                            </svg>
                            <p class="font-bold">{{ value }}</p>
                        </div>
                    </div>
                </template>
                <template #fecha_nacimiento="{ item }">
                    <div class="  w-22 items-center  mx-auto  ">
                        <div class="flex gap-2 justify-between ">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                class=" self-center text-blue-500">
                                <path
                                    d="M20 10V7C20 5.89543 19.1046 5 18 5H6C4.89543 5 4 5.89543 4 7V10M20 10V19C20 20.1046 19.1046 21 18 21H6C4.89543 21 4 20.1046 4 19V10M20 10H4M8 3V7M16 3V7"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                <rect x="6" y="12" width="3" height="3" rx="0.5" fill="currentColor" />
                                <rect x="10.5" y="12" width="3" height="3" rx="0.5" fill="currentColor" />
                                <rect x="15" y="12" width="3" height="3" rx="0.5" fill="currentColor" />
                            </svg>
                            <p>{{ new Date(item.fecha_nacimiento).toLocaleDateString() }}</p>
                        </div>
                    </div>
                </template>
                <template #servicios="{ value }">
                    <div class="flex flex-wrap gap-2 justify-start overflow-hidden max-w-[75%]">
                        <template v-for="(servicio, s) in value" :key="s">
                            <div v-if="s < 5" class="px-3 py-1 bg-gray-300 rounded-full text-sm min-w-fit">
                                {{ servicio.nombre }}
                            </div>
                        </template>

                        <button v-if="value.length > 5" class="px-3 py-1 text-blue-600 text-sm hover:underline"
                            @click="toggleServiciosPrestados(value)">
                            Ver más ({{ value.length - 5 }})
                        </button>
                    </div>
                </template>
                <template #id="{ item }">
                    <div class="flex items-center">
                        <input type="checkbox" :checked="item.status === 1" @click="toggleSwitch(item, item.status)"
                            class="sr-only" :id="`toggleSwitch-${item.id}`" />
                        <label :for="`toggleSwitch-${item.id}`" class="flex items-center cursor-pointer">
                            <div :class="[
                                'relative w-14 h-7 rounded-full transition-colors duration-200 ease-in-out',
                                item.status === 1 ? 'bg-green-500' : 'bg-gray-300'
                            ]">
                                <div :class="[
                                    'absolute left-0.5 top-0.5 w-6 h-6 bg-white rounded-full shadow transition-transform duration-200 ease-in-out transform flex items-center justify-center',
                                    item.status === 1 ? 'translate-x-7' : 'translate-x-0'
                                ]">
                                    <svg v-show="item.showSpingStatus" class="animate-spin h-5 w-5 text-gray-900" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </label>
                    </div>
                </template>
                <template #revision="{ item }">
                    <div class="flex items-center">
                        <input type="checkbox" :checked="item.revision === 1"
                            @click="toggleSwitchRevision(item, item.revision)" class="sr-only"
                            :id="`toggleSwitchRevision-${item.id}`" />
                        <label :for="`toggleSwitchRevision-${item.id}`" class="flex items-center cursor-pointer">
                            <div :class="[
                                'relative w-14 h-7 rounded-full transition-colors duration-200 ease-in-out',
                                item.revision === 1 ? 'bg-green-500' : 'bg-gray-300'
                            ]">
                                <div :class="[
                                    'absolute left-0.5 top-0.5 w-6 h-6 bg-white rounded-full shadow transition-transform duration-200 ease-in-out transform flex items-center justify-center',
                                    item.revision === 1 ? 'translate-x-7' : 'translate-x-0'
                                ]">
                                    <svg v-show="item.showSpingRevision" class="animate-spin h-5 w-5 text-gray-900" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </label>
                    </div>

                </template>
                <template #9="{ item }">
                    <div class="flex justify-center">
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                            class="self-center text-purple-600 cursor-pointer " @click="ShowDocumentos(item)">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M12 8.25C9.92893 8.25 8.25 9.92893 8.25 12C8.25 14.0711 9.92893 15.75 12 15.75C14.0711 15.75 15.75 14.0711 15.75 12C15.75 9.92893 14.0711 8.25 12 8.25ZM9.75 12C9.75 10.7574 10.7574 9.75 12 9.75C13.2426 9.75 14.25 10.7574 14.25 12C14.25 13.2426 13.2426 14.25 12 14.25C10.7574 14.25 9.75 13.2426 9.75 12Z"
                                fill="currentColor" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M12 3.25C7.48587 3.25 4.44529 5.9542 2.68057 8.24686L2.64874 8.2882C2.24964 8.80653 1.88206 9.28392 1.63269 9.8484C1.36564 10.4529 1.25 11.1117 1.25 12C1.25 12.8883 1.36564 13.5471 1.63269 14.1516C1.88206 14.7161 2.24964 15.1935 2.64875 15.7118L2.68057 15.7531C4.44529 18.0458 7.48587 20.75 12 20.75C16.5141 20.75 19.5547 18.0458 21.3194 15.7531L21.3512 15.7118C21.7504 15.1935 22.1179 14.7161 22.3673 14.1516C22.6344 13.5471 22.75 12.8883 22.75 12C22.75 11.1117 22.6344 10.4529 22.3673 9.8484C22.1179 9.28391 21.7504 8.80652 21.3512 8.28818L21.3194 8.24686C19.5547 5.9542 16.5141 3.25 12 3.25ZM3.86922 9.1618C5.49864 7.04492 8.15036 4.75 12 4.75C15.8496 4.75 18.5014 7.04492 20.1308 9.1618C20.5694 9.73159 20.8263 10.0721 20.9952 10.4545C21.1532 10.812 21.25 11.2489 21.25 12C21.25 12.7511 21.1532 13.188 20.9952 13.5455C20.8263 13.9279 20.5694 14.2684 20.1308 14.8382C18.5014 16.9551 15.8496 19.25 12 19.25C8.15036 19.25 5.49864 16.9551 3.86922 14.8382C3.43064 14.2684 3.17374 13.9279 3.00476 13.5455C2.84684 13.188 2.75 12.7511 2.75 12C2.75 11.2489 2.84684 10.812 3.00476 10.4545C3.17374 10.0721 3.43063 9.73159 3.86922 9.1618Z"
                                fill="currentColor" />
                        </svg>
                    </div>
                </template>
            </tableComponent>
        </div>
        <DialogComponent :show="showModalIdentificacion">
            <template #title>
                <div class="flex justify-between">
                    <p> Identificación </p>
                    <svg width="20px" height="20px" viewBox="0 0 512 512" version="1.1"
                        @click="showModalIdentificacion = false" class=" cursor-pointer  ">
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="work-case" fill="#000000" transform="translate(91.520000, 91.520000)">
                                <polygon id="Close"
                                    points="328.96 30.2933333 298.666667 1.42108547e-14 164.48 134.4 30.2933333 1.42108547e-14 1.42108547e-14 30.2933333 134.4 164.48 1.42108547e-14 298.666667 30.2933333 328.96 164.48 194.56 298.666667 328.96 328.96 298.666667 194.56 164.48">

                                </polygon>
                            </g>
                        </g>
                    </svg>
                </div>
            </template>
            <template #content>
                <div class="space-y-4">
                    <img :src="IDSHOW.front" alt="ID Frontal" class="w-full h-auto object-cover rounded-lg shadow-md" />
                    <!-- Imagen trasera -->
                    <img :src="IDSHOW.back" alt="ID Trasera" class="w-full h-auto object-cover rounded-lg shadow-md" />
                </div>
            </template>
        </DialogComponent>
        <DialogComponent :show="showModalAvatar">
            <template #title>
                <div class="flex justify-between">
                    <p> Avatar </p>
                    <svg width="20px" height="20px" viewBox="0 0 512 512" version="1.1" @click="showModalAvatar = false"
                        class=" cursor-pointer  ">
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="work-case" fill="#000000" transform="translate(91.520000, 91.520000)">
                                <polygon id="Close"
                                    points="328.96 30.2933333 298.666667 1.42108547e-14 164.48 134.4 30.2933333 1.42108547e-14 1.42108547e-14 30.2933333 134.4 164.48 1.42108547e-14 298.666667 30.2933333 328.96 164.48 194.56 298.666667 328.96 328.96 298.666667 194.56 164.48">

                                </polygon>
                            </g>
                        </g>
                    </svg>
                </div>
            </template>
            <template #content>
                <div class="space-y-4">
                    <img :src="AVATARSHOW" alt="ID Frontal" class="w-full h-auto object-cover rounded-lg shadow-md" />
                </div>
            </template>
        </DialogComponent>
        <DialogComponent :show="showModalDocumentos">
            <template #title>
                <div class="flex justify-between">
                    <p> Certificados </p>
                    <svg width="20px" height="20px" viewBox="0 0 512 512" version="1.1"
                        @click="showModalDocumentos = false" class=" cursor-pointer  ">
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="work-case" fill="#000000" transform="translate(91.520000, 91.520000)">
                                <polygon id="Close"
                                    points="328.96 30.2933333 298.666667 1.42108547e-14 164.48 134.4 30.2933333 1.42108547e-14 1.42108547e-14 30.2933333 134.4 164.48 1.42108547e-14 298.666667 30.2933333 328.96 164.48 194.56 298.666667 328.96 328.96 298.666667 194.56 164.48">

                                </polygon>
                            </g>
                        </g>
                    </svg>
                </div>
            </template>
            <template #content>
                <div class="grid grid-cols-2 gap-4">
                    <div v-for="(doc, index) in documentos" :key="index">
                        <!-- Si es una imagen (jpeg, jpg, png) -->
                        <div v-if="isImage(doc.url_documento_especialista)">
                            <img :src="doc.url_documento_especialista" alt="Documento"
                                class="w-full h-auto rounded-lg object-cover" />
                        </div>

                        <!-- Si no es una imagen, mostrar el enlace -->
                        <div v-else class="flex items-center justify-start">
                            <a :href="doc.url_documento_especialista" target="_blank" class="text-blue-500 underline">
                                Abrir Documento
                            </a>
                        </div>
                    </div>
                </div>
            </template>
        </DialogComponent>
        <DialogComponent :show="showModalServicios">
            <template #title>
                <div class="flex justify-between">
                    <p> Servicios prestados </p>
                    <svg width="20px" height="20px" viewBox="0 0 512 512" version="1.1"
                        @click="showModalServicios = false" class=" cursor-pointer  ">
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="work-case" fill="#000000" transform="translate(91.520000, 91.520000)">
                                <polygon id="Close"
                                    points="328.96 30.2933333 298.666667 1.42108547e-14 164.48 134.4 30.2933333 1.42108547e-14 1.42108547e-14 30.2933333 134.4 164.48 1.42108547e-14 298.666667 30.2933333 328.96 164.48 194.56 298.666667 328.96 328.96 298.666667 194.56 164.48">

                                </polygon>
                            </g>
                        </g>
                    </svg>
                </div>
            </template> 
            <template #content>
                <div class="flex flex-wrap gap-2 justify-start overflow-hidden max-w-[75%]">
                        <template v-for="(servicio, s) in serviciosPrestados" :key="s">
                            <div  class="px-3 py-1 bg-gray-300 rounded-full text-sm min-w-fit">
                                {{ servicio.nombre }}
                            </div>
                        </template>
                    </div>
            </template>
        </DialogComponent>
    </AppLayout>
</template>
