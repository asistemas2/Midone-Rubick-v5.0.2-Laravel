# Carga inicial de la base de datos local de Docker

Solo aplica al perfil `db-local` (`docker compose --profile db-local up -d`).

La primera vez que se crea el contenedor `db` (con el volumen `dbdata` vacío), PostgreSQL
ejecuta en orden alfabético los archivos `*.sql` de esta carpeta. Ponga aquí el backup en
**SQL plano sin dueños** (por ejemplo `infraestructura_AAAA-MM-DD_HHMM_plano.sql`).

- Los `.sql` de esta carpeta **no se versionan**: contienen datos reales.
- La carga ocurre **una sola vez**. Para volver a cargar un backup:
  `docker compose --profile db-local down` y luego `docker volume rm gestion-zfp_dbdata`
  (borra la base local de Docker; no afecta al servidor de la red ni a Laragon).
- Para generar un backup nuevo, ver `C:\laragon\backups\LEEME_restauracion.txt`.
