import { createApp } from "vue";
import Dashboard from "../Pages/Dashboard.vue";

export function initDashboardPages() {
    const dashboardEl = document.getElementById("appDashboard");
    if (dashboardEl) {
        // Le pasamos los datos de window.userData como "props" al componente
        const app = createApp(Dashboard, {
            user: window.userData || null,
        });
        app.mount(dashboardEl);
    }
}
