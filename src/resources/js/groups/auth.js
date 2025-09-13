import { createApp } from "vue";
import Login from "../Pages/Auth/Login.vue";
// En el futuro, aquí también importarías Register.vue, ForgotPassword.vue, etc.

// Esta función buscará los puntos de montaje de las páginas de autenticación
export function initAuthPages() {
    const loginEl = document.getElementById("appLogin");
    if (loginEl) {
        createApp(Login).mount(loginEl);
    }

    // const registerEl = document.getElementById('appRegister');
    // if (registerEl) {
    //     createApp(Register).mount(registerEl);
    // }
}
