# Seguro App - Frontend con Laravel y Vue

Este es el frontend para el sistema de gestión de seguros, construido con Laravel y Vue 3. La aplicación se ejecuta en un entorno Dockerizado para el servidor de PHP/Nginx y el servidor de desarrollo de Vite, conectándose a una base de datos MySQL local y a una API externa de NestJS.

## Requisitos Previos

-   **Docker Desktop** (para Windows/Mac) o **Docker Engine + Compose** (para Linux).
-   Una instancia de **MySQL Server** corriendo en tu máquina local (fuera de Docker).
-   **Git**.

## Configuración y Puesta en Marcha

Sigue estos pasos para levantar el entorno de desarrollo local.

### 1. Clonar el Repositorio

```bash
git clone [URL_DE_TU_REPOSITORIO_GIT]
cd seguro-laravel
```

### 2. Configurar el Archivo de Entorno (`.env`)

Este es el paso más importante. Debes configurar Laravel para que se conecte a tu base de datos local y a la API de NestJS.

1.  Navega a la carpeta `src`:
    ```bash
    cd src
    ```
2.  Copia el archivo de ejemplo:
    ```bash
    cp .env.example .env
    ```
3.  **Edita el nuevo archivo `.env`** y ajusta las siguientes secciones:

    **Para la Base de Datos:**

    ```env
    DB_CONNECTION=mysql
    DB_HOST=host.docker.internal # Dirección especial para conectar desde Docker a tu localhost
    DB_PORT=3306
    DB_DATABASE=seguro_laravel   # Asegúrate de que esta BD exista en tu MySQL local
    DB_USERNAME=root             # Tu usuario de MySQL
    DB_PASSWORD=1989             # Tu contraseña de MySQL
    ```

    **Para la API de NestJS:**

    ```env
    NESTJS_API_URL=[http://157.250.198.106:9031](http://157.250.198.106:9031)
    NESTJS_API_KEY=K0rd35D13L4r4v31P455w0rdd3L4AplAqulv4E57035eGuR0
    ```

4.  Vuelve a la carpeta raíz:
    ```bash
    cd ..
    ```

### 3. Levantar los Contenedores de Docker

Este comando iniciará los servicios de la aplicación (`app`) y de Vite (`vite`).

```bash
docker compose up -d
```

### 4. Instalar Dependencias

Con los contenedores corriendo, ejecuta los siguientes comandos para instalar las dependencias de PHP y Node.js.

```bash
# Instalar dependencias de Composer (PHP)
docker compose exec app composer install

# Instalar dependencias de NPM (Node/Vue)
docker compose run --rm vite npm install --legacy-peer-deps
```

### 5. Finalizar la Configuración de Laravel

Estos comandos preparan tu aplicación de Laravel para su primer uso.

```bash
# Generar la clave de la aplicación
docker compose exec app php artisan key:generate

# Ejecutar las migraciones en tu base de datos local
docker compose exec app php artisan migrate
```

**¡Listo!** El entorno está completamente configurado.

---

## Acceso a la Aplicación

-   **Aplicación Web**: Abre tu navegador y ve a **[http://localhost:8000](http://localhost:8000)**. Serás redirigido a la página de login.

---

## Comandos Útiles de Docker

-   **Ver el estado de los contenedores:**
    ```bash
    docker compose ps
    ```
-   **Detener todos los contenedores:**
    ```bash
    docker compose down
    ```
-   **Ver los logs de un servicio (ej. `app` o `vite`):**
    ```bash
    docker compose logs -f app
    ```
-   **Ejecutar cualquier comando de Artisan:**
    ```bash
    docker compose exec app php artisan [tu-comando]
    ```
-   **Abrir una terminal dentro del contenedor `app`:**
    ```bash
    docker compose exec app bash
    ```

---

## Notas para Diferentes Sistemas Operativos

-   **Windows (con Docker Desktop y WSL2):** Los comandos funcionan tal cual. `host.docker.internal` es la dirección correcta en el `.env`.
-   **Linux (Ubuntu, etc.):** Los comandos son los mismos. Si encuentras problemas de permisos en la carpeta `src` después de crear archivos con `artisan`, ejecuta `sudo chown -R $USER:$USER .` desde la raíz del proyecto (`seguro-laravel`).
