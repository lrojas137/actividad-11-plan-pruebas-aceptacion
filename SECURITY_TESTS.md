# Pruebas y mejoras de seguridad - Gestión de pacientes

## 1. Framework seleccionado

Se seleccionó Laravel como framework PHP seguro para el desarrollo del módulo web de gestión de pacientes clínicos.

Laravel facilita la implementación de:

- Autenticación de usuarios.
- Hash seguro de contraseñas.
- Validación de datos de entrada.
- Protección CSRF en formularios.
- Middleware para control de acceso.
- Manejo de sesiones.
- Separación de rutas, controladores, modelos y vistas.

## 2. Autenticación implementada

Se implementó autenticación usando Laravel Breeze.

Funcionalidades verificadas:

| Prueba | Resultado |
|---|---|
| Registro de usuario | Correcto |
| Inicio de sesión | Correcto |
| Cierre de sesión | Correcto |
| Contraseñas almacenadas con hash | Correcto |
| Validación básica de formularios | Correcto |
| Manejo de errores de login | Correcto |

## 3. Roles implementados

Se agregó la columna `role` a la tabla `users`.

Roles definidos:

| Rol | Descripción |
|---|---|
| admin | Usuario administrativo con acceso limitado a datos clínicos |
| doctor | Usuario médico con acceso a información clínica protegida |

Usuarios de prueba:

| Usuario | Contraseña | Rol |
|---|---|---|
| admin@test.com | Admin12345! | admin |
| doctor@test.com | Doctor12345! | doctor |

## 4. Autorización en backend

Se creó el middleware `CheckRole`.

Este middleware valida que el usuario autenticado tenga el rol permitido antes de acceder a rutas protegidas.

Rutas protegidas:

| Ruta | Rol permitido | Resultado esperado |
|---|---|---|
| `/admin` | admin | Solo accede administrador |
| `/doctor` | doctor | Solo accede doctor |
| `/patients/{patient}` | admin, doctor | Acceden ambos roles, pero con diferente información visible |

Pruebas realizadas:

| Prueba | Resultado |
|---|---|
| Admin accede a `/admin` | Correcto |
| Admin bloqueado en `/doctor` | Correcto |
| Doctor accede a `/doctor` | Correcto |
| Doctor bloqueado en `/admin` | Correcto |
| Admin accede a perfil limitado del paciente | Correcto |
| Doctor accede a perfil clínico completo | Correcto |

## 5. Autorización en frontend

Se modificó el menú de navegación para mostrar opciones según el rol autenticado.

| Usuario | Botón visible |
|---|---|
| admin | Panel Admin |
| doctor | Panel Doctor |

Esto mejora la experiencia del usuario y evita mostrar botones de secciones no autorizadas.

## 6. Vista de perfil de paciente

Se creó una vista de perfil de paciente con control de información según el rol.

### Usuario administrador

El administrador puede ver:

- Documento.
- Nombre completo.
- Fecha de nacimiento.
- Teléfono.
- Correo.

El administrador no puede ver:

- Diagnóstico.
- Tratamiento.
- Notas médicas.
- Dirección completa.

### Usuario doctor

El doctor puede ver:

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

## 7. Manejo de errores de autorización

Se creó una página personalizada para el error 403.

Archivo creado:

```text
resources/views/errors/403.blade.php
```

Esta página se muestra cuando un usuario intenta acceder a una ruta no permitida para su rol.

## 8. Expiración de sesión por inactividad

Se creó el middleware `SessionTimeout`.

Archivo creado:

```text
app/Http/Middleware/SessionTimeout.php
```

Tiempo configurado:

```text
900 segundos = 15 minutos
```

Si el usuario permanece inactivo más de 15 minutos, la sesión se invalida y debe iniciar sesión nuevamente.

## 9. Mejoras implementadas

Durante el desarrollo se identificaron e implementaron las siguientes mejoras:

| Mejora | Estado |
|---|---|
| Middleware para roles | Implementado |
| Middleware con soporte para varios roles | Implementado |
| Página personalizada de error 403 | Implementado |
| Expiración de sesión por inactividad | Implementado |
| Ocultar botones según rol | Implementado |
| Separación de datos visibles según rol | Implementado |
| Protección explícita de ruta `patients.show` | Implementado |

## 10. Posibles mejoras futuras

Se recomiendan las siguientes mejoras para una versión posterior:

- Implementar policies de Laravel para control más granular por paciente.
- Registrar auditoría de accesos a perfiles clínicos.
- Cifrar campos sensibles de pacientes en base de datos.
- Implementar doble factor de autenticación.
- Asignar pacientes a doctores específicos.
- Crear módulo CRUD completo de pacientes.
- Aplicar pruebas automatizadas con PHPUnit.
- Agregar logs de intentos fallidos de acceso.
- Fortalecer política de contraseñas.
- Configurar HTTPS en entorno de producción.

## 11. Conclusión técnica

La aplicación implementa un módulo básico de seguridad para el acceso a registros de pacientes clínicos. Se aplicaron controles de autenticación, autorización por roles, restricción de vistas, protección de datos sensibles, manejo de errores de autorización y expiración de sesión por inactividad.
