<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

// Estado para almacenar los grupos de menú obtenidos de la API
const menuGroups = ref([]);
// Estado para controlar qué grupo del acordeón está abierto
const openGroupId = ref(null);
// Estados para manejar la carga y los errores
const isLoading = ref(true);
const error = ref(null);

// Función para alternar la visibilidad de las opciones del menú (acordeón)
const toggleGroup = (groupId) => {
    openGroupId.value = openGroupId.value === groupId ? null : groupId;
};

// Al montar el componente, hacemos la llamada a la API para obtener el menú
onMounted(async () => {
    try {
        // Usamos la URL que definimos en el archivo Blade
        const response = await axios.get(window.Laravel.urlPermisos);
        menuGroups.value = response.data;
        console.log("Menú cargado desde la API:", menuGroups.value);
    } catch (err) {
        error.value = "Error al cargar el menú.";
        console.error(err);
    } finally {
        isLoading.value = false;
    }
});
</script>

<template>
    <div class="flex h-screen bg-gray-200">
        <aside class="w-64 flex-shrink-0 bg-gray-800 text-white p-4">
            <h1 class="text-2xl font-bold mb-6 text-center">SeguroApp</h1>

            <div v-if="isLoading">Cargando menú...</div>
            <div v-if="error" class="text-red-400">{{ error }}</div>

            <nav v-else>
                <div v-for="group in menuGroups" :key="group.id" class="mb-2">
                    <button
                        @click="toggleGroup(group.id)"
                        class="w-full flex items-center justify-between p-2 rounded hover:bg-gray-700 focus:outline-none"
                    >
                        <div class="flex items-center">
                            <span
                                class="w-6 h-6 mr-3"
                                v-html="group.icono"
                            ></span>
                            <span>{{ group.nombre }}</span>
                        </div>
                        <span
                            :class="{ 'rotate-180': openGroupId === group.id }"
                            class="transform transition-transform duration-200"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                ></path>
                            </svg>
                        </span>
                    </button>

                    <ul
                        v-if="openGroupId === group.id"
                        class="mt-2 ml-4 pl-4 border-l-2 border-gray-600"
                    >
                        <li
                            v-for="option in group.opciones"
                            :key="option.id"
                            class="py-1"
                        >
                            <a
                                :href="option.url"
                                class="flex items-center text-sm text-gray-300 hover:text-white"
                            >
                                <span
                                    class="w-5 h-5 mr-2"
                                    v-html="option.icono"
                                ></span>
                                {{ option.nombre }}
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </aside>

        <main class="flex-1 p-10 overflow-auto">
            <h1 class="text-3xl font-bold text-gray-800">
                Bienvenido al Dashboard
            </h1>
            <p class="mt-2 text-gray-600">
                Selecciona una opción del menú para comenzar.
            </p>
        </main>
    </div>
</template>

<style>
/* Pequeño ajuste para que los SVG de los iconos se vean bien */
aside svg {
    width: 100%;
    height: 100%;
    fill: currentColor;
    stroke: currentColor;
}
</style>
