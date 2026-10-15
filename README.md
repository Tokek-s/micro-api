# Micro API

API de items hecha con Laravel y MariaDB.

## Antes de empezar

- Git
- Docker con Docker Compose v2
- PHP 8.2 y Composer 2 (para preparar el proyecto y correr pruebas)

## Clonar y preparar

```bash
git clone https://github.com/Tokek-s/micro-api.git
cd micro-api
cp .env.example .env
composer install
php artisan key:generate
```

Si quieres, cambia en `.env` el nombre de la base, el usuario y las contraseñas. Los valores del ejemplo son locales.

## Levantar el proyecto

```bash
docker compose up --build -d
```

Comando para ver contenedores y logs:

```bash
docker compose ps
docker compose logs -f api
docker compose logs -f db
```

La API queda en `http://localhost:8000`. La base se prepara sola y los datos quedan en el volumen `db_data`. `docker compose down` conserva los datos; `docker compose down -v` los borra.

## Probar la API

Salud de API y base:

```bash
curl http://localhost:8000/api/health
```

Crear un item:

```bash
curl -X POST http://localhost:8000/api/items \
  -H "Content-Type: application/json" \
  -d '{"name":"Item de prueba","description":"Descripción del item"}'
```

Ver los items:

```bash
curl http://localhost:8000/api/items
```

Comando para entrar a MariaDB:

```bash
docker compose exec db mariadb -uroot -p
```

Ingresa la contraseña `DB_ROOT_PASSWORD` de tu `.env`.

## Pruebas

```bash
php artisan test
```

Las pruebas usan SQLite en memoria. GitHub Actions también corre las pruebas y construye la imagen en cada push o pull request a `main`.

## Decisiones

Usé Laravel porque ya trae rutas, validación y acceso a base de datos sin agregar muchas dependencias. Con más tiempo agregaría paginación, autenticación y despliegue automático desde CI.
