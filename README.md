# 🔥 Proyecto WebAPI Solgas – Laravel + Docker + SQL Server

Este proyecto es una API Laravel dockerizada, conectada a una base de datos MySQL local y a una base de datos SQL Server remota (AWS). Es utilizada para validar códigos de cilindros Solgas y registrar información de clientes.

---

## 🚀 Requisitos

- Docker + Docker Compose
- Git
- PHP (solo si querés ejecutarlo fuera de Docker)

---

## 🧬 Estructura del proyecto

```
webapi/
├── app/
├── config/
├── docker/
│   ├── nginx/
│   │   └── default.conf
│   ├── mysql/
│   │   └── dump.sql ← (opcional, si no contiene datos sensibles)
│   └── php/
│       └── Dockerfile
├── public/
├── routes/
├── storage/
├── .env.example
├── docker-compose.yml
├── composer.json
└── README.md
```

---

## 🧑‍💻 Primeros pasos

### 1. Clonar el repositorio

```bash
git clone https://github.com/tu_usuario/tu_repositorio.git
cd webapi
```

---

### 2. Crear archivo `.env`

```bash
cp .env.example .env
```

> ⚠️ Completar el archivo `.env` con tus propias credenciales para MySQL y SQL Server.

---

### 3. Colocar el archivo `dump.sql` (si aplica)

Si quieres importar datos de ejemplo:

```bash
# Colocar tu dump en esta ruta:
docker/mysql/dump.sql
```

O si no tenés ninguno, podés crear un archivo vacío:

```bash
touch docker/mysql/dump.sql
```

---

### 4. Construir y levantar los contenedores

```bash
docker compose up --build
```

---

### 5. Instalar dependencias de Laravel

```bash
docker compose exec laravel-app composer install
docker compose exec laravel-app php artisan key:generate
docker compose exec laravel-app php artisan migrate
```

> ⚠️ Asegurate de tener conexión a internet si vas a usar una base SQL Server remota.

---

## ✅ Comandos útiles

- Limpiar caché de configuración:
  ```bash
  docker compose exec laravel-app php artisan config:clear
  ```

- Ver logs de Laravel:
  ```bash
  docker compose exec laravel-app tail -f storage/logs/laravel.log
  ```

---

## 🌐 Acceso local

La aplicación corre en:  
**[http://localhost:8000](http://localhost:8000)**

---

## 🧠 Notas adicionales

- El archivo `.env` **no se sube al repositorio**, se debe crear localmente a partir de `.env.example`.
- El contenedor `laravel-app` incluye soporte para MySQL y SQL Server (pdo_sqlsrv).
- SQL Server requiere `trust_server_certificate=true` para evitar errores SSL si no tenés CA instalados.
