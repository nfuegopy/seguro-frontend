<script setup>
// Definimos las "props" que el componente espera recibir.
// En este caso, un objeto 'user'.
const props = defineProps({
    user: {
        type: Object,
        default: () => ({ nombreCompleto: "Invitado", rol: "N/A" }),
    },
});
</script>

<template>
    <div class="p-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold">
                        ¡Bienvenido de nuevo, {{ props.user.nombreCompleto }}!
                    </h1>

                    <p class="mt-4">Has iniciado sesión correctamente.</p>
                    <p class="mt-2 text-gray-600">
                        Tu rol es:
                        <span class="font-semibold text-indigo-600">{{
                            props.user.rol
                        }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
