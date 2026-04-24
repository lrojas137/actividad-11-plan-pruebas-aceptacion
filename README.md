# Gestión segura de pacientes clínicos - Laravel

Proyecto desarrollado como laboratorio del módulo de Desarrollo de Aplicaciones Seguras.

La aplicación implementa un módulo de seguridad para el acceso a registros de pacientes clínicos, utilizando Laravel como framework PHP seguro.

## Objetivo del proyecto

Implementar una aplicación web local que permita gestionar el acceso a información de pacientes mediante autenticación, autorización por roles y protección de datos clínicos sensibles.

## Tecnologías utilizadas

- PHP 8.2
- Laravel 12
- Laravel Breeze
- MySQL
- XAMPP
- Composer
- Node.js y NPM
- Visual Studio Code
- Git y GitHub

## Funcionalidades implementadas

- Registro de usuarios.
- Inicio de sesión.
- Cierre de sesión.
- Hash seguro de contraseñas.
- Validación básica de formularios.
- Roles de usuario:
  - Administrador.
  - Doctor.
- Middleware de autorización por rol.
- Middleware de expiración de sesión por inactividad.
- Vista personalizada para error 403.
- Panel independiente para administrador.
- Panel independiente para doctor.
- Vista de perfil de paciente.
- Visualización limitada de datos para administrador.
- Visualización completa de datos clínicos para doctor.
- Menú dinámico según el rol del usuario.

## Roles del sistema

| Rol | Permisos |
|---|---|
| admin | Puede acceder al panel administrativo y ver información limitada de pacientes |
| doctor | Puede acceder al panel médico y ver información clínica completa de pacientes |

## Usuarios de prueba

| Usuario | Contraseña | Rol |
|---|---|---|
| admin@test.com | Admin12345! | admin |
| doctor@test.com | Doctor12345! | doctor |

## Rutas principales

| Ruta | Descripción | Acceso |
|---|---|---|
| `/register` | Registro de usuarios | Público |
| `/login` | Inicio de sesión | Público |
| `/dashboard` | Panel general | Usuario autenticado |
| `/admin` | Panel de administrador | Solo admin |
| `/doctor` | Panel del doctor | Solo doctor |
| `/patients/{patient}` | Perfil de paciente | Admin y doctor, con datos según rol |

## Seguridad implementada

### Autenticación

La autenticación fue implementada con Laravel Breeze, permitiendo registro, inicio de sesión, cierre de sesión y manejo básico de errores.

### Hash de contraseñas

Las contraseñas se almacenan de forma segura usando los mecanismos de hashing de Laravel.

### Autorización por roles

Se creó el middleware `CheckRole`, que valida el rol del usuario antes de permitir el acceso a rutas protegidas.

Ejemplos:

```php
->middleware(['auth', 'role:admin'])
->middleware(['auth', 'role:doctor'])
->middleware(['auth', 'role:admin,doctor'])
```

### Expiración de sesión

Se creó el middleware `SessionTimeout`, que invalida la sesión después de 15 minutos de inactividad.

```php
protected int $timeout = 900;
```

### Manejo de errores

Se creó una vista personalizada para el error 403:

```text
resources/views/errors/403.blade.php
```

Esta vista se muestra cuando un usuario intenta acceder a una ruta sin permisos suficientes.

## Vista de paciente según rol

### Administrador

El administrador puede ver información limitada:

- Documento.
- Nombre completo.
- Fecha de nacimiento.
- Teléfono.
- Correo.

No puede ver:

- Diagnóstico.
- Tratamiento.
- Notas médicas.
- Dirección completa.

### Doctor

El doctor puede ver información clínica completa:

- Documento.
- Nombre completo.
- Fecha de nacimiento.
- Teléfono.
- Correo.
- Dirección.
- Tipo de sangre.
- Diagnóstico.
- Tratamiento.
- Notas médicas.

## Instalación local

Clonar el repositorio:

```bash
git clone https://github.com/lrojas137/gestion-pacientes-laravel.git
```

Entrar a la carpeta:

```bash
cd gestion-pacientes-laravel
```

Instalar dependencias PHP:

```bash
composer install
```

Instalar dependencias frontend:

```bash
npm install
```

Copiar archivo de entorno:

```bash
copy .env.example .env
```

Generar clave de aplicación:

```bash
php artisan key:generate
```

Configurar base de datos en `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_pacientes_db
DB_USERNAME=root
DB_PASSWORD=
```

Ejecutar migraciones:

```bash
php artisan migrate
```

Compilar recursos frontend:

```bash
npm run build
```

Ejecutar servidor local:

```bash
php artisan serve
```

Abrir en el navegador:

```text
http://127.0.0.1:8000
```

## Pruebas de seguridad

Las pruebas realizadas se documentan en el archivo:

```text
SECURITY_TESTS.md
```

## Mejoras futuras

- Implementar auditoría de accesos a perfiles clínicos.
- Cifrar campos sensibles de pacientes en base de datos.
- Implementar doble factor de autenticación.
- Asignar pacientes a doctores específicos.
- Crear CRUD completo de pacientes.
- Aplicar pruebas automatizadas.
- Configurar HTTPS en producción.

## Conclusión

El proyecto implementa una aplicación web segura básica para la gestión de pacientes clínicos, aplicando autenticación, autorización por roles, protección de datos sensibles, manejo de errores y expiración de sesión por inactividad.