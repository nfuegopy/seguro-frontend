import "./bootstrap";
import "../css/app.css";

// Importamos la función de nuestro nuevo grupo
import { initAuthPages } from "./groups/auth";
import { initDashboardPages } from "./groups/dashboard";

// Ejecutamos la inicialización de las páginas de autenticación
initAuthPages();
initDashboardPages();
