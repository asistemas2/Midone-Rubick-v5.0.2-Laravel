# AGENTS.md

Guía para agentes de código (Claude Code, Codex, Copilot, etc.) que trabajen en este repositorio. Para instalación y descripción funcional, ver `README.md`.

## Qué es

Sistema de gestión de activos y mantenimiento de **Zona Franca Palmaseca**: inmuebles, equipos, mantenimientos (con criterio/criticidad, presupuesto aprobado y costo real), garantías, calendario y reporte de presupuesto.

- Laravel 10 · PHP 8.1 · **PostgreSQL** · Blade + plantilla **Midone/Rubick v5.0.2** (Tailwind + Vite)
- `spatie/laravel-permission` (roles: `Administrador`, `Operador`, `Usuario`) y `laravel/socialite` (Google)
- Entorno de desarrollo: Windows + Laragon. Idioma del código de dominio, la UI y los commits: **español**.

## Reglas críticas

- **La base de datos de `.env` es compartida** (servidor PostgreSQL en red, base `infraestructura`). No ejecutes `migrate:fresh`, `migrate:refresh`, `db:wipe`, `db:seed` completo ni tests con `RefreshDatabase`: `phpunit.xml` **no** usa SQLite, apunta a esa misma base. Para probar escrituras, envuelve todo en `DB::beginTransaction()` … `DB::rollBack()`.
- `php artisan migrate` (solo migraciones nuevas y reversibles) sí está permitido; avisa al usuario que otros ambientes deben correrlo también.
- No edites `.env` sin pedir permiso. `.env.example` sí se versiona: sin IPs, usuarios ni secretos reales.
- No hagas commit ni push salvo que el usuario lo pida. Rama principal: `main`.

## Comandos

```bash
php artisan route:list --path=gestion
php artisan route:cache          # las rutas ESTÁN cacheadas en local: tras tocar routes/web.php regenera (o route:clear)
php artisan view:cache           # compila todas las vistas: sirve para detectar errores de Blade
php -l ruta/Archivo.php          # lint rápido
npm run build                    # solo si agregas entradas nuevas a vite.config.js o clases Tailwind nuevas
```

## Arquitectura

```
app/Http/Controllers/Gestion/          Inmuebles, Equipos, AsignacionEquipo, Mantenimiento, Garantia
app/Http/Controllers/Parametrizacion/  9 catálogos (CRUD simples)
app/Http/Requests/{Gestion,Parametrizacion}/  Store*/Update* FormRequests (validación + mensajes en español)
app/Http/Middleware/EnsureUserIsActive.php    alias 'activo', aplicado junto a 'auth'
app/Main/TopMenu.php                   ÚNICO menú en uso (SideMenu/SimpleMenu son de la plantilla, sin uso)
app/View/Composers/MenuComposer.php    fuerza el layout 'top-menu' (solo 'base' para login)
app/Providers/AppServiceProvider.php   macro Eloquent ->buscar()
resources/views/{gestion,parametrizacion}/<recurso>/{index,create,edit,show}.blade.php
resources/views/components/base/       componentes x-base.* de Rubick
```

Rutas (`routes/web.php`): `/parametrizacion/*` → `role:Administrador`; `/gestion/*` → `role:Administrador|Operador`; `/gestion/usuarios` → solo Administrador. Las rutas específicas de mantenimientos (`presupuesto`, `calendario`, `completar`, endpoints JSON) van **antes** del `Route::resource`.

## Modelo de dominio (lo no obvio)

- **Mantenimiento** se asocia a un inmueble o equipo por relación polimórfica `activoRelacionado()` (`activo_type` = clase completa, `activo_id`), además de `tipo_activo` (`inmueble|equipo`). `activo` es una columna **booleana** distinta (registro activo/inactivo); por eso el `morphTo` usa `__FUNCTION__` como nombre — no lo cambies a `'activo'`.
- Estados: `programado → en_proceso → completado | cancelado`. Cambia el estado con `Mantenimiento::cambiarEstado()`, que registra en `mantenimiento_historial`.
- **Completar** (`MantenimientoController@completar`, modal en `mantenimientos/show.blade.php`): en una sola transacción hace `cambiarEstado('completado')` con `costo_real`, guarda documentos (disco `public`, `mantenimientos/{id}`) y, opcionalmente, crea el siguiente mantenimiento (`programar_nuevo` + campos `nuevo_*`) y una garantía (`registrar_garantia` + campos `garantia_*`, asociada al mantenimiento y a su activo). Si agregas otra sección opcional, sigue ese mismo patrón: casilla + campos con prefijo + `required_if`.
- El detalle de mantenimiento no tiene panel lateral: las acciones (Completar, Editar, Volver) van solo en el encabezado.
- **Garantías** guardan `tipo_activo` + `activo_id` (sin `activo_type`): usa `Inmueble::garantias()` / `Equipo::garantias()` y `$garantia->activo_garantizado` para resolver el activo. Los detalles de Inmueble y Equipo reutilizan `gestion/partials/_tabla-mantenimientos` y `_tabla-garantias`.
- **Perfil** (`ProfileController`, vistas `gestion/usuarios/profile*.blade.php` + `partials/_perfil-menu`): basado en las demos `update-profile` / `change-password`.
- Campos de dinero: `presupuesto_aprobado` (al programar; antes se llamaba `costo_aproximado`/"estimado" — no reintroduzcas esos términos) y `costo_real` (al completar).
- `criterio_mantenimiento` (enum: `riesgo_vida`, `riesgo_operacional`, `riesgo_sancionatorio`, `riesgo_activo`) + `criticidad_mantenimiento_id` (tabla `criticidades_mantenimiento`: Grave/Moderado/Leve). La mayoría de registros históricos no tienen criterio ni criticidad: es esperado.
- **Ficha técnica** de inmueble (`fichas_tecnicas_inmuebles`) solo aplica a bodegas: usa `$inmueble->esBodega()` / `TipoInmueble::esBodega()`; nunca compares el texto `'Bodega'` a mano. Si deja de ser bodega, la ficha se conserva oculta.
- Casi todos los modelos tienen `scopeActivos()` y `SoftDeletes`.
- **Códigos consecutivos**: `Mantenimiento` (MT), `Inmueble` (INM), `Equipo` (EQ) y `Garantia` (GAR) usan el trait `TieneConsecutivo` + `const PREFIJO_CODIGO`; el código se asigna solo al crear (`App\Support\Consecutivo`, formato `PREFIJO-0000`, bloqueo de fila en la tabla `consecutivos`). No pidas ni valides `codigo` en formularios/FormRequests de esos recursos y no lo hagas editable. Se conservan los códigos antiguos (`MT-0932`, `INM-105`); la secuencia continúa desde el número más alto existente. Para un recurso nuevo con consecutivo: agrega el trait, la constante y una fila en `consecutivos` (se crea sola si falta). Los catálogos de Parametrización mantienen códigos descriptivos manuales.

## Convenciones obligatorias

**Las pantallas se construyen con base en la plantilla.** Toda vista nueva o rediseñada parte de la página de demostración más parecida de Midone/Rubick (`resources/views/pages/*.blade.php`, servidas por `PageController` en las rutas `*-page`) y usa los componentes disponibles en `resources/views/components/base/` (`x-base.*`). Adapta textos y datos; no inventes estructura ni estilos propios si la plantilla ya trae un equivalente. Ejemplos: perfil → `update-profile` / `profile-overview-*`; contraseña → `change-password`; formularios → `crud-form` / `regular-form`; tablas → `regular-table`; calendario → `calendar`. **No borres** las páginas demo ni sus rutas: son la referencia.

**Blade + componentes `x-base.*`**
- Nunca pongas `{{ ... }}` suelto dentro de una etiqueta `<x-...>` (p. ej. `{{ $x ? 'checked' : '' }}`): Blade deja de compilar el componente y el navegador recibe la etiqueta literal. Usa props: `:checked="..."`, `:disabled="..."`. (`{{ }}` *dentro del valor* de un atributo, como `class="a {{ $b }}"`, sí funciona.)
- Tampoco uses directivas como `@error ... @enderror` dentro de los atributos de un `<x-...>`: no se compilan y la clase llega literal (el campo se ve **siempre** en rojo). Para resaltar un campo con error: `class="w-full {{ $errors->has('campo') ? 'border-danger' : '' }}"`. El mensaje `@error('campo') <div ...>{{ $message }}</div> @enderror` va **fuera** del componente.
- Tampoco uses `\"` dentro de atributos de componentes; para pulgadas usa `″`.
- Checkbox/switch booleano: `<input type="hidden" name="campo" value="0" />` **antes** del checkbox, y en el servidor `$request->boolean('campo')`. Para el switch "Activo" de un formulario, agrega el trait `App\Http\Requests\Concerns\NormalizaActivo` a sus FormRequests (ausente = `false`). **No** lo uses si el formulario no tiene ese switch (p. ej. Equipos): desactivaría el registro en cada edición.
- Íconos: `<x-base.lucide icon="Nombre" />`. Formato de moneda: `number_format($v, 2, ',', '.')`.

**Listados con filtros**
```php
Modelo::activos()
    ->buscar(['nombre', 'codigo'], $request->buscar)   // agrupa ORs, insensible a mayúsculas (ilike en pgsql)
    ->when($request->filled('x_id'), fn ($q) => $q->where('x_id', $request->x_id))
    ->paginate(15)->withQueryString();
```
No uses `->where(...)->orWhere(...)` sin agrupar ni `'like'` directo (en PostgreSQL distingue mayúsculas). En la vista: `<form method="GET" class="flex flex-wrap gap-2">`, cada `<x-base.form-select ... onchange="this.form.submit()">`, y `<x-filtros-limpiar route="modulo.recurso.index" />` al final.

**Menú**: agrega ítems en `app/Main/TopMenu.php` (sin `params => ['layout' => ...]`).

**Formularios**: validación en FormRequests con mensajes en español; reglas de negocio que dependan del dominio, en el modelo o el controlador, no solo en JavaScript.
- No hay archivos de idioma `es` (`lang/`): sin mensaje personalizado, el usuario ve la clave cruda (`validation.required`). Define el mensaje de **cada** regla nueva.
- Toda vista que reciba un `redirect()->with('success'|'error')` debe mostrar esos mensajes (patrón: `index.blade.php` de cada módulo o `mantenimientos/show.blade.php`).
- Formularios dentro de un modal (`x-base.dialog`): muestra `$errors` dentro del modal, conserva valores con `old()` y reábrelo si hubo errores:
  ```blade
  @if ($errors->any())
      <script type="module">
          tailwind.Modal.getOrCreateInstance(document.getElementById('id-del-modal')).show();
      </script>
  @endif
  ```

## Cómo verificar cambios

No hay suite de tests útil (solo los ejemplos de Laravel). Verifica así:

1. `php -l` en los PHP tocados y `php artisan view:cache` para las vistas.
2. Petición real por el kernel, autenticado como administrador, sin navegador (script PHP en un directorio temporal, ejecutado desde la raíz del proyecto):
   ```php
   require 'vendor/autoload.php';
   $app = require 'bootstrap/app.php';
   $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class); $kernel->bootstrap();
   $app->instance(App\Http\Middleware\VerifyCsrfToken::class, new class { function handle($r, $n) { return $n($r); } }); // solo para POST/PUT
   $req = Illuminate\Http\Request::create('/gestion/inmuebles', 'GET', ['buscar' => 'bodega']);
   $app->instance('request', $req);
   Illuminate\Support\Facades\Auth::guard('web')->setUser(App\Models\User::role('Administrador')->first());
   $res = $kernel->handle($req);   // ->getStatusCode(), ->getContent(), session('errors')
   ```
   Para escrituras, `DB::beginTransaction()` antes y `DB::rollBack()` al final. Compara contra una consulta directa a la base.
3. Comportamiento de JavaScript/CSS (switches, selects que envían, calendario): Chrome headless con `--remote-debugging-port` sirviendo `public/` con `php -S`. Borra cualquier archivo temporal que dejes en `public/`.

## Problemas conocidos (pendientes)

- Login con Google: esos usuarios tienen una contraseña aleatoria que no conocen, así que no pueden usar "Cambiar contraseña" (pide la actual).
- Equipos no tiene switch "Activo" en sus formularios: un equipo solo se puede desactivar/eliminar desde el listado.
- `PageController` y sus rutas `*-page` son las demos de la plantilla: se conservan como referencia de diseño (ver la regla de pantallas), aunque estén accesibles para usuarios autenticados.
