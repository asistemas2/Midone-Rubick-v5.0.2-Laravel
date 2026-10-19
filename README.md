# Gestión de Activos y Mantenimiento — Zona Franca Palmaseca

Aplicación web para administrar los **inmuebles** y **equipos** de la zona franca, programar y auditar sus **mantenimientos**, controlar **garantías** y hacer seguimiento del **presupuesto aprobado vs. costo real ejecutado**.

Construida sobre **Laravel 10** con la plantilla de administración **Midone / Rubick v5.0.2** (Tailwind CSS + Vite).

---

## Stack

| Capa | Tecnología |
|---|---|
| Backend | PHP 8.1+, Laravel 10 |
| Base de datos | PostgreSQL |
| Frontend | Blade + componentes `x-base.*` de Rubick, Tailwind CSS, Vite |
| Autenticación | Login con correo/contraseña y con Google (`laravel/socialite`) |
| Roles y permisos | `spatie/laravel-permission` |
| Calendario | FullCalendar 6 (incluido en la plantilla) |

---

## Instalación local (Laragon)

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate
```

Configura en `.env`:

```dotenv
APP_NAME="Gestion ZFP"
APP_URL=http://midone-rubick-v5.0.2-laravel.test   # o la URL de tu virtual host

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=infraestructura
DB_USERNAME=postgres
DB_PASSWORD=

# Login con Google (opcional)
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"
```

Crea la base de datos y carga los datos iniciales:

```bash
php artisan migrate --seed
php artisan storage:link      # documentos adjuntos de los mantenimientos (disco public)
npm run build                 # o `npm run dev` mientras desarrollas
```

### Usuario inicial

El seeder crea un administrador:

- **Correo:** `admin@zfp.com`
- **Contraseña:** `password`

> Cambia esta contraseña en cualquier ambiente que no sea local.

Además se crean 9 usuarios de prueba y los catálogos/datos de ejemplo a partir de `database/seeders/data/*.json` (inmuebles, equipos y mantenimientos).

---

## Roles

| Rol | Acceso |
|---|---|
| **Administrador** | Todo: Parametrización, Gestión y Usuarios |
| **Operador** | Módulos de Gestión (sin Usuarios) |
| **Usuario** | Rol por defecto de quien entra con Google por primera vez. Solo ve el Dashboard y su perfil hasta que un administrador le asigne otro rol |

Un usuario **inactivo** no puede iniciar sesión (ni con contraseña ni con Google), y si se desactiva estando conectado, su sesión se cierra en la siguiente petición (middleware `activo`). Un administrador no puede desactivar su propia cuenta.

---

## Módulos

### Parametrización (`/parametrizacion`, solo Administrador)
Catálogos: Bloques, Tipos de inmueble, Periodicidades de mantenimiento, Niveles de deterioro, Categorías y Tipos de equipo, Estados de equipo, Marcas y Criticidades de equipo.

### Gestión (`/gestion`)
- **Inmuebles** — con ubicación en mapa, nivel de deterioro y **ficha técnica**. La ficha técnica solo se diligencia y se muestra para inmuebles de tipo **Bodega** (`TipoInmueble::esBodega()`); si un inmueble deja de ser bodega, su ficha se conserva oculta.
- **Equipos** y **Asignación de equipos** a inmuebles.
- **Mantenimientos**
  - Asociados a un inmueble o a un equipo (relación polimórfica `activoRelacionado`).
  - Tipo: preventivo, correctivo o predictivo. Estados: programado → en proceso → completado / cancelado.
  - **Criterio** (riesgo de vida, operacional, sancionatorio o sobre el activo) y **criticidad** (Grave, Moderado, Leve), con select dependiente.
  - **Presupuesto aprobado** al programar y **costo real** al completar.
  - Historial de cambios de estado, documentos adjuntos y garantías asociadas.
  - **Calendario** (`/gestion/mantenimientos/calendario`) y reporte de **Presupuesto** (aprobado vs. ejecutado, por mes, tipo, responsable y activo).
- **Garantías**
- **Usuarios** (solo Administrador)

### Dashboard
Indicadores, alertas de mantenimientos vencidos y próximos, y un calendario resumido.

---

## Estructura relevante

```
app/
├── Http/Controllers/
│   ├── Gestion/            # Inmuebles, Equipos, Asignaciones, Mantenimientos, Garantías
│   ├── Parametrizacion/    # Catálogos
│   └── Auth/SocialiteController.php
├── Http/Middleware/EnsureUserIsActive.php
├── Main/TopMenu.php        # Menú de navegación (el que se usa)
├── Models/
└── View/Composers/MenuComposer.php   # Fija el layout top-menu en toda la app
resources/views/
├── gestion/  parametrizacion/
├── components/base/        # Componentes de la plantilla Rubick
└── layouts/top-menu.blade.php
```

---

## Convenciones del proyecto

**Layout y menú.** Todas las vistas usan el layout `top-menu`; lo fija `MenuComposer` (solo el login usa `base`). Los ítems del menú se definen en `app/Main/TopMenu.php`. `SideMenu.php` y `SimpleMenu.php` son de la plantilla y no se usan.

**Búsqueda en listados.** Usa el macro de consultas `buscar()` (definido en `AppServiceProvider`), que agrupa los `OR` y no distingue mayúsculas en PostgreSQL:

```php
Inmueble::activos()
    ->buscar(['nombre', 'codigo'], $request->buscar)
    ->when($request->filled('bloque_id'), fn ($q) => $q->where('bloque_id', $request->bloque_id))
    ->paginate(15)
    ->withQueryString();
```

En la vista, los `select` de filtro llevan `onchange="this.form.submit()"` y el formulario incluye `<x-filtros-limpiar route="..." />`.

**Checkboxes y switches en Blade.** No escribas `{{ ... ? 'checked' : '' }}` dentro de una etiqueta `<x-...>`: Blade deja de reconocer el componente y el navegador recibe la etiqueta literal. Usa la prop y un hidden para el valor apagado:

```blade
<input type="hidden" name="activo" value="0" />
<x-base.form-switch.input type="checkbox" id="activo" name="activo" value="1" :checked="old('activo', $modelo->activo)" />
```

Por la misma razón, evita `\"` dentro de atributos de componentes (para pulgadas usa `″`).

**Caché.** En local las rutas pueden estar cacheadas (`bootstrap/cache/routes-v7.php`). Si agregas rutas y no aparecen:

```bash
php artisan route:clear     # o php artisan route:cache para regenerarla
php artisan view:clear
```

---

## Comandos útiles

```bash
npm run dev                         # Vite en modo desarrollo
npm run build                       # Compilar assets para producción
php artisan migrate                 # Aplicar migraciones pendientes
php artisan db:seed --class=CriticidadesMantenimientoSeeder
php artisan route:list --path=gestion
```
