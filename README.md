# Actividad 11 - Plan de Pruebas de Aceptación

## Descripción del proyecto

Este repositorio contiene el desarrollo de la **Actividad 11: Plan de Pruebas de Aceptación**, realizada para una aplicación web de gestión de pacientes clínicos desarrollada en **Laravel**. La actividad tuvo como finalidad diseñar, ejecutar y documentar pruebas de aceptación, pruebas funcionales, pruebas de API, pruebas de seguridad, pruebas de compatibilidad y pruebas de rendimiento.

## Herramientas utilizadas

- **Laravel**: framework utilizado para la aplicación web.
- **XAMPP / MySQL**: entorno local y base de datos.
- **TestLink**: diseño y gestión de casos de prueba de aceptación.
- **Selenium con Python**: automatización de pruebas de interfaz de usuario.
- **Postman**: pruebas de API y validación de endpoints.
- **Apache JMeter**: pruebas de carga y estrés.
- **GitHub**: almacenamiento del proyecto, scripts, evidencias e informe final.
- **Visual Studio Code**: edición del código y ejecución de comandos.

## Pruebas realizadas

### 1. Diseño de casos de prueba en TestLink

Se creó un proyecto de pruebas en TestLink y se diseñaron suites para organizar los casos de prueba de aceptación. Las suites creadas fueron:

- Registro de nuevos pacientes.
- Búsqueda de pacientes.
- Actualización de información de pacientes.
- Registro de historial médico.

### 2. Pruebas de interfaz con Selenium

Se desarrollaron scripts en Python con Selenium para automatizar flujos principales de la aplicación, como:

- Validación de carga del login.
- Inicio de sesión con rol administrador y doctor.
- Acceso a paneles según permisos.
- Consulta de perfil de pacientes.
- Validaciones de errores y rutas protegidas.
- Visualización de historial médico según el rol del usuario.

### 3. Pruebas de API con Postman

Se creó una colección en Postman para validar los endpoints de la aplicación. Las pruebas incluyeron:

- Listado de pacientes.
- Consulta de paciente por ID.
- Creación de paciente.
- Actualización de paciente.
- Consulta y actualización de historial médico.
- Listado de doctores.
- Validación de errores por datos inválidos.
- Validación de seguridad mediante API Key.

### 4. Flujos realistas frontend/backend

Se probaron escenarios que combinan la interfaz web con la API, verificando que la información consultada desde Postman coincida con la información mostrada en la aplicación. También se validó el acceso diferenciado entre usuarios administrador y doctor.

### 5. Pruebas de volumen

Se creó un seeder para insertar registros simulados de pacientes en la base de datos. Con esta información se validó que la aplicación pudiera seguir funcionando correctamente con una base de datos cargada.

### 6. Pruebas de seguridad y permisos

Se verificaron controles básicos de autenticación y autorización, incluyendo:

- Redirección al login cuando un usuario no autenticado intenta acceder a rutas protegidas.
- Bloqueo de acceso entre roles no autorizados.
- Restricción de información clínica sensible para el rol administrador.
- Acceso a información clínica para el rol doctor.
- Bloqueo de solicitudes API sin API Key o con API Key incorrecta.

### 7. Smoke Test Suite

Se creó una suite de pruebas automatizadas para validar rápidamente los flujos críticos de la aplicación:

- Carga del login.
- Acceso como administrador.
- Acceso como doctor.
- Bloqueo de usuario no autenticado.
- Visualización del perfil clínico por parte del doctor.

### 8. Pruebas de compatibilidad

Se ejecutaron pruebas básicas de compatibilidad en los navegadores **Google Chrome** y **Microsoft Edge**, verificando que la página de login cargara correctamente en ambos entornos.

### 9. Pruebas de carga y estrés con JMeter

Se realizaron pruebas de rendimiento utilizando Apache JMeter:

- **Prueba de carga:** 20 usuarios virtuales, 280 muestras y 0.00% de errores.
- **Prueba de estrés:** 50 usuarios virtuales, 700 muestras y 0.00% de errores.

Los resultados permitieron comprobar que la aplicación se mantuvo operativa durante las pruebas, aunque los tiempos de respuesta aumentaron bajo mayor carga, lo cual es esperado en un entorno local de desarrollo.

### 10. Simulación de evaluación por usuario final

Se documentó una simulación hipotética de evaluación por usuario final. Esta aclaración se realizó porque, en un entorno real, el visto bueno formal debe ser dado por un usuario autorizado, como un médico, administrador de clínica o responsable del sistema.

La simulación permitió representar una prueba de aceptación sobre los flujos principales del sistema.

## Ejecución del proyecto Laravel

Para instalar dependencias del proyecto:

```bash
composer install
npm install
```

Crear el archivo de configuración:

```bash
cp .env.example .env
php artisan key:generate
```

Configurar la base de datos en el archivo `.env` y ejecutar migraciones:

```bash
php artisan migrate
```

Ejecutar la aplicación localmente:

```bash
php artisan serve
```

La aplicación quedará disponible en:

```text
http://127.0.0.1:8000
```

## Ejecución de pruebas Selenium

Activar el entorno virtual de Python e instalar Selenium:

```bash
python -m venv .venv
.\.venv\Scripts\Activate.ps1
pip install selenium
```

Ejecutar una prueba específica:

```bash
python selenium_tests/test_login_roles.py
```

Ejecutar el smoke test crítico:

```bash
python selenium_tests/smoke_test_suite.py
```

## Ejecución de pruebas API en Postman

1. Abrir Postman.
2. Importar la colección ubicada en la carpeta `postman`.
3. Configurar la variable `base_url` con el valor:

```text
http://127.0.0.1:8000
```

4. Agregar el encabezado de seguridad en las solicitudes protegidas:

```text
X-API-KEY: clave-demo-actividad-11
```

## Resultados generales

La actividad permitió validar que la aplicación cumple con los flujos principales de aceptación definidos para el taller. Se comprobó el funcionamiento de la autenticación, autorización, consulta de pacientes, acceso por roles, endpoints API, control de errores, compatibilidad básica y rendimiento bajo carga local.

Como oportunidad de mejora, se recomienda ampliar los formularios de registro y actualización, fortalecer la gestión del historial médico y optimizar el rendimiento para ambientes de producción.
