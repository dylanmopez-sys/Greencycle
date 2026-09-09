# GreenCycle

Aplicación web gamificada donde cada persona usuaria administra un vivero digital. Cada árbol tiene un tipo, nivel, salud, progreso y estado, y el servidor controla las reglas del juego. Proyecto desarrollado para el curso **TM4100**, sobre la plantilla base de Laravel proporcionada por el profesor.

## Alcance actual (Sprint 1)

Al finalizar esta entrega, una persona usuaria puede:
- Plantar un árbol indicando un tipo de semilla.
- Consultar el listado de árboles registrados.
- Consultar el detalle de un árbol específico.

Pendiente para próximas entregas: autenticación de usuarios con Laravel Sanctum, exposición de los endpoints como API REST bajo `/api` con respuestas JSON, autorización por propiedad (que cada usuario solo acceda a sus propios árboles), validación de entrada, y las reglas de cuidado, cooldown, deterioro, cosecha, economía e inventario previstas para Sprint 2 y Sprint 3.

## Propósito

Esta aplicación proporciona un entorno inicial para aprender y practicar:

- Arquitectura MVC.
- Rutas y controladores.
- Vistas con Blade.
- Formularios y validación de datos.
- Eloquent ORM.
- Migraciones y seeders.
- Integración con PostgreSQL.
- Pruebas automatizadas.
- Control de versiones con Git y GitHub.
- Integración continua con GitHub Actions.
- Despliegue de aplicaciones web.

## Tecnologías

El proyecto utiliza las siguientes tecnologías:

- PHP 8.5.
- Laravel 13.
- Laravel Herd.
- Blade.
- CSS.
- JavaScript.
- Vite.
- PostgreSQL en Neon.
- PHPUnit.
- Laravel Pint.
- GitHub Actions.
- Render.

## Requisitos locales

Antes de instalar el proyecto, asegúrese de contar con:

- Windows 10 o una versión posterior.
- Laravel Herd.
- PHP 8.5.
- Composer 2.
- Node.js 26.
- npm.
- Git.
- Visual Studio Code.
- Una cuenta de Neon.
- Una cuenta de Render.

> No es necesario instalar Docker ni PostgreSQL localmente.

## Instalación local

### 1. Clonar el repositorio

Abra PowerShell y ejecute:

```powershell
git clone https://github.com/dylanmopez-sys/Greencycle.git
Set-Location Greencycle
```

### 2. Aplicar la configuración de Laravel Herd

```powershell
herd init
herd isolate 8.5
```

### 3. Seleccionar la versión de Node.js

```powershell
nvm use
```

> Este comando utiliza la versión de Node.js definida para el proyecto.

### 4. Instalar las dependencias

Instale las dependencias de PHP:

```powershell
composer install
```

Instale las dependencias de frontend:

```powershell
npm ci
```

### 5. Crear la configuración local

Copie el archivo de configuración de ejemplo:

```powershell
Copy-Item .env.example .env
```

Genere la clave de la aplicación:

```powershell
php artisan key:generate
```

### 6. Configurar la base de datos

Abra el archivo `.env` y agregue la conexión correspondiente a la rama `development` de Neon:

```dotenv
DB_CONNECTION=pgsql
DB_URL="URL_DE_NEON_DEVELOPMENT"
DB_SSLMODE=require
```

> Sustituya `URL_DE_NEON_DEVELOPMENT` por la cadena de conexión proporcionada por Neon. Esta cadena nunca debe subirse al repositorio.

### 7. Limpiar la configuración almacenada

```powershell
php artisan optimize:clear
```

### 8. Ejecutar las migraciones y seeders

```powershell
php artisan migrate --seed
```

### 9. Iniciar Vite

```powershell
npm run dev
```

Mantenga esta terminal abierta mientras desarrolla la aplicación.

### 10. Abrir la aplicación

Visite la siguiente dirección en el navegador:

```text
http://greencycle.test
```

## API (Sprint 1)

Endpoints actualmente disponibles (sin autenticación todavía, ver "Alcance actual"):

| Método | Ruta | Descripción |
|---|---|---|
| GET | `/trees/list` | Lista los árboles registrados. |
| GET | `/trees/{id}` | Consulta el detalle de un árbol. |
| GET | `/trees/create/{user_id}/{seed_id}` | Planta un árbol (endpoint de prueba). |

## Comprobaciones del proyecto

Antes de crear un commit o un pull request, ejecute las siguientes comprobaciones.

### Ejecutar las pruebas automatizadas

```powershell
php artisan test
```

### Comprobar el formato del código PHP

```powershell
.\vendor\bin\pint --test
```

Para corregir automáticamente el formato:

```powershell
.\vendor\bin\pint
```

### Crear los recursos de producción

```powershell
npm run build
```

## Ambientes

| Ambiente | Aplicación | Base de datos |
|---|---|---|
| Desarrollo | Laravel Herd | Neon `development` |
| Pruebas | PHPUnit | SQLite en memoria |
| Producción | Render | Neon `production` |

## Seguridad

Nunca deben publicarse o incluirse en el repositorio:

- El archivo `.env`.
- Las credenciales de Neon.
- El valor de `APP_KEY`.
- Tokens de GitHub.
- Contraseñas.
- Claves de API.
- Archivos que contengan información privada.
- Cadenas de conexión de bases de datos.

Antes de realizar un commit, revise los archivos modificados:

```powershell
git status
```

## Flujo de trabajo

El flujo recomendado para desarrollar una funcionalidad es el siguiente:

1. Actualizar la rama `main`.
2. Crear una nueva rama de trabajo.
3. Desarrollar la funcionalidad.
4. Ejecutar las pruebas localmente.
5. Comprobar el formato del código.
6. Crear el commit.
7. Publicar la rama en GitHub.
8. Crear un pull request.
9. Esperar las comprobaciones automáticas.
10. Revisar el código.
11. Fusionar el pull request mediante **squash**.
12. Actualizar el repositorio local.

### Actualizar la rama principal

```powershell
git switch main
git pull origin main
```

### Crear una rama de trabajo

```powershell
git switch -c feature/nombre-de-la-funcionalidad
```

### Guardar los cambios

```powershell
git add .
git commit -m "feat: agregar nombre de la funcionalidad"
```

### Publicar la rama

```powershell
git push -u origin feature/nombre-de-la-funcionalidad
```

### Actualizar el repositorio después de fusionar

```powershell
git switch main
git pull origin main
```

## Equipo y atribuciones

- Ana Benavides Zúñiga
- Alessandro López Palma
- Dylan Molina López

## Estado del proyecto

El repositorio utiliza GitHub Actions para validar pruebas, formato y recursos frontend.
