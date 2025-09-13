<script setup>
import { ref } from "vue";
import axios from "axios";

// La lógica del formulario se mantiene igual
const form = ref({
    email: "",
    password: "",
});

const errorMessage = ref("");
const processing = ref(false);

const submit = async () => {
    processing.value = true;
    errorMessage.value = "";
    try {
        await axios.post("/login", form.value);
        window.location.href = "/dashboard";
    } catch (error) {
        if (error.response && error.response.status === 422) {
            errorMessage.value = error.response.data.errors.email[0];
        } else {
            errorMessage.value = "Ocurrió un error inesperado.";
        }
    } finally {
        processing.value = false;
        form.value.password = "";
    }
};
</script>

<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-200">
        <div
            id="login"
            class="w-80 bg-indigo-50 rounded shadow-lg flex flex-col justify-between p-3"
        >
            <div
                v-if="errorMessage"
                class="p-3 mb-4 text-sm text-red-700 bg-red-100 rounded-lg text-center"
                role="alert"
            >
                {{ errorMessage }}
            </div>

            <form class="text-indigo-500" @submit.prevent="submit">
                <fieldset class="border-4 border-dotted border-indigo-500 p-5">
                    <legend class="px-2 italic -mx-2 font-semibold">
                        ¡Bienvenido de nuevo!
                    </legend>

                    <label
                        class="text-xs font-bold after:content-['*'] after:text-red-400"
                        for="email"
                        >Email</label
                    >
                    <input
                        v-model="form.email"
                        class="w-full p-2 mb-2 mt-1 outline-none ring-none focus:ring-2 focus:ring-indigo-500 rounded"
                        type="email"
                        required
                        autofocus
                    />

                    <label
                        class="text-xs font-bold after:content-['*'] after:text-red-400"
                        for="password"
                        >Contraseña</label
                    >
                    <input
                        v-model="form.password"
                        class="w-full p-2 mb-2 mt-1 outline-none ring-none focus:ring-2 focus:ring-indigo-500 rounded"
                        type="password"
                        required
                    />

                    <a
                        href="#"
                        class="block text-right text-xs text-indigo-500 text-right mb-4"
                        >¿Olvidaste tu contraseña?</a
                    >

                    <button
                        type="submit"
                        :disabled="processing"
                        class="w-full rounded bg-indigo-500 text-indigo-50 p-2 text-center font-bold hover:bg-indigo-400 disabled:bg-gray-400"
                    >
                        Ingresar
                    </button>
                </fieldset>
            </form>
        </div>
    </div>
</template>
