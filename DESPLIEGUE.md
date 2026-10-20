# Despliegue en el servidor con Docker (Portainer)

Guía para instalar **Gestión ZFP** en el servidor `10.0.10.5`, que ya tiene Portainer CE y otros
contenedores. La aplicación queda en **http://10.0.10.5:8081** y usa la base `infraestructura` del
contenedor `postgres` (stack `postgres-stack`).

| Elemento | Valor |
|---|---|
| Carpeta del proyecto | `/home_datos/proyectos/gestion-zfp` |
| Datos persistentes (documentos, logs, sesiones) | `/home_datos/proyectos/gestion-zfp/data/storage` |
| Contenedores | `gestion-zfp-app` (PHP-FPM) y `gestion-zfp-web` (Nginx) |
| Puerto | `8081` (8080 ya lo usa pgAdmin) |
| Base de datos | contenedor `postgres`, red `postgres-stack_zfp-net`, usuario `zfpadmin` |

Los comandos `docker compose` de esta guía se ejecutan **dentro de la carpeta del proyecto** y
siempre con los dos archivos. Para no repetirlos, defina un alias en la sesión:

```bash
alias dc='docker compose -f docker-compose.yml -f docker-compose.server.yml'
```

---

## 1. Requisitos (una sola vez)

Conéctese al servidor por SSH y verifique:

```bash
docker --version
docker compose version        # debe ser v2.x
git --version                 # si no está: sudo apt install git  (o el gestor del sistema)
docker network ls | grep postgres-stack_zfp-net    # la red del PostgreSQL debe existir
ss -ltn | grep ':8081 '        # no debe mostrar nada (puerto libre)
```

Acceso al repositorio de GitHub: si el repositorio es privado, necesita un
**token personal** (GitHub → Settings → Developer settings → Personal access tokens, permiso de
lectura del repositorio) o una **deploy key** SSH. Al clonar por HTTPS, use el token como contraseña.

## 2. Clonar el proyecto

```bash
cd /home_datos/proyectos
git clone -b feature/docker https://github.com/asistemas2/Midone-Rubick-v5.0.2-Laravel.git gestion-zfp
cd gestion-zfp
alias dc='docker compose -f docker-compose.yml -f docker-compose.server.yml'
```

> Cuando la rama se integre a `main`, clone con `-b main`.

## 3. Configurar la aplicación (`.env.docker`)

```bash
cp .env.docker.example .env.docker
chmod 600 .env.docker
nano .env.docker
```

Complete como mínimo:

| Variable | Valor |
|---|---|
| `APP_KEY` | La misma del entorno actual (Laragon, archivo `.env`). Si no la tiene, ver paso 5 |
| `APP_URL` | `http://10.0.10.5:8081` (ya viene así) |
| `DB_HOST` / `DB_PORT` | `postgres` / `5432` (ya vienen así) |
| `DB_USERNAME` / `DB_PASSWORD` | `zfpadmin` / la contraseña del usuario |
| `GOOGLE_CLIENT_ID` / `GOOGLE_CLIENT_SECRET` | Las del entorno actual (login con Google) |
| `GOOGLE_REDIRECT_URI` | `http://10.0.10.5:8081/auth/google/callback` (ya viene así) |

`POSTGRES_*` no se usan en el servidor (solo para la base local de Docker).
`.env.docker` contiene contraseñas: no lo suba al repositorio (ya está en `.gitignore`).

## 4. Construir y levantar

```bash
dc up -d --build
```

La primera vez tarda varios minutos (descarga imágenes, instala dependencias y compila los assets).
Al terminar:

```bash
dc ps                        # gestion-zfp-app y gestion-zfp-web en estado "running"
dc logs --tail=50 app        # no debe haber errores
```

## 5. Solo si `APP_KEY` quedó vacía

```bash
dc run --rm app php artisan key:generate --show
```

Copie el valor (`base64:...`) en `APP_KEY` de `.env.docker` y recree el contenedor:

```bash
dc up -d
```

> Con una `APP_KEY` nueva, las sesiones abiertas se cierran; los datos no se ven afectados.

## 6. Verificar la base de datos

```bash
dc exec app php artisan migrate:status        # todas las migraciones en "Ran"
dc exec app php artisan tinker --execute="echo DB::table('users')->count();"   # debe mostrar 11
```

**No ejecute** `migrate:fresh`, `migrate:refresh`, `db:wipe` ni `db:seed`: borrarían o duplicarían los
datos reales.

## 7. Documentos adjuntos existentes (si los hay)

Los archivos subidos (facturas, actas, fotos) no están en la base de datos. Si el entorno anterior
tiene archivos en `storage/app/public/mantenimientos/`, cópielos (por ejemplo con WinSCP) a:

```
/home_datos/proyectos/gestion-zfp/data/storage/app/public/mantenimientos/
```

y ajuste el dueño:

```bash
dc exec app chown -R www-data:www-data storage/app/public
```

## 8. Probar

Abra **http://10.0.10.5:8081** y verifique: inicio de sesión, listados con filtros, detalle de un
mantenimiento, calendario y perfil de usuario.

En Portainer, el stack aparece como **gestion-zfp** (creado fuera de Portainer: se puede ver, detener,
reiniciar y consultar logs, pero se actualiza por consola).

**Login con Google:** registre `http://10.0.10.5:8081/auth/google/callback` en la consola de Google
(APIs & Services → Credentials → el cliente OAuth → Authorized redirect URIs).

---

## Actualizar a una versión nueva

```bash
cd /home_datos/proyectos/gestion-zfp
git pull
dc up -d --build
dc exec app php artisan migrate --force      # solo si la versión trae migraciones nuevas
```

Haga un backup de la base antes de aplicar migraciones (ver `LEEME_restauracion.txt`).

## Operación diaria

| Acción | Comando |
|---|---|
| Ver estado | `dc ps` |
| Ver logs | `dc logs -f app` / `dc logs -f web` / `tail -f data/storage/logs/laravel.log` |
| Reiniciar | `dc restart` |
| Detener | `dc down` (los datos de `data/` y la base no se borran) |
| Consola de Laravel | `dc exec app php artisan ...` |

## Problemas frecuentes

| Síntoma | Causa / solución |
|---|---|
| `network postgres-stack_zfp-net not found` | El stack `postgres-stack` no está corriendo o la red cambió de nombre. Verifique con `docker network ls` y ajuste `docker-compose.server.yml` |
| `Bind for 0.0.0.0:8081 failed: port is already allocated` | El puerto está ocupado. Use otro: `APP_PORT=8090 dc up -d` y actualice `APP_URL` y `GOOGLE_REDIRECT_URI` |
| `SQLSTATE[08006] ... could not translate host name "postgres"` | La app no está en la red del PostgreSQL: levántela con los dos archivos (`dc`, no `docker compose` solo) |
| `password authentication failed for user "zfpadmin"` | Contraseña incorrecta en `.env.docker`; corríjala y ejecute `dc up -d` |
| Error 500 sin detalle | `dc logs app` y `data/storage/logs/laravel.log`. Tras cambiar `.env.docker`, siempre `dc up -d` (las cachés se regeneran al arrancar) |
| `Permission denied` en `storage` | `dc exec app chown -R www-data:www-data storage` |
| Los cambios de `.env.docker` no se aplican | `dc restart` no relee el archivo: use `dc up -d` |

---

## Otros modos (fuera del servidor)

- **Laragon:** sin cambios; usa `.env` como siempre.
- **Desarrollo con Docker** (código montado en vivo):
  `docker compose -f docker-compose.yml -f docker-compose.dev.yml up -d --build`
- **Local con base propia:** poner el backup `_plano.sql` en `docker/db/init/`, `DB_HOST=db` en
  `.env.docker` y `docker compose --profile db-local up -d --build`.
