# Api-challenges

Api para sistema User, Challenges, Videos

## Requisitos

- Laravel (versión 11.9)
- MyslSQL (versión 8.3.0)
- Sanctum (versión 4.0)
- Api Huggingface

## Instalación

1. Clona el repositorio:
   ```bash
   git clone https://github.com/Johnja85/api-challenges.git
   cd tu-repositorio

2. Instala las dependencias
    composer install
    composer require laravel/sanctum
    php artisan install:api


3. Configura la base de datos:

    Crea una base de datos en MySQL. api_challenges_db y para pruebas unitarias test_api_challenges_db

4. Variables de entorno .env:
    - El archivo .env.example se debe renombrar como .env, aquí esta el token para autenticación con AI Huggingface.
    - Se comparte .env.testing para pruebas unitarias.
    - Configura el archivo .env con tus credenciales de base de datos.

5. Generar APP_KEY, es la llave para cada proyecto de Laravel:
    php artisan key:generate

6. Migraciones
    Ejecutar las migraciones: php artisan migrate

7. Inicio de proyecto:
    php artisan serve

## USO

* URL o endpoint: http://api-challenges.test:{PUERTO_LOCAL}

* Para autenticación
    POS /api/v1/login
    POS /api/v1/logout

* Para user
    POS /api/v1/user
    GET /api/v1/user
    GET /api/v1/user/{id}
    PUT /api/v1/user/{id}

* Para challenges
    POS /api/v1/challenges
    GET /api/v1/challenges
    GET /api/v1/challenges/{id}
    DELETE /api/v1/challenges/{id}
    PUT /api/v1/challenges/{id}

* Para videos
    POS /api/v1/videos
    GET /api/v1/videos
    GET /api/v1/videos/{id}
    DELETE /api/v1/videos/{id}
    PUT /api/v1/videos/{id}

# Contribuir
Si deseas contribuir, por favor sigue estos pasos:

Haz un fork del repositorio.
Crea una rama con tu nueva funcionalidad (git checkout -b feature/nueva-funcionalidad).
Haz commit de tus cambios (git commit -m 'Añadir nueva funcionalidad').
Sube tu rama (git push origin feature/nueva-funcionalidad).
Crea un nuevo Pull Request.
