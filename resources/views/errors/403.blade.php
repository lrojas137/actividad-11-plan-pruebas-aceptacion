<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso no autorizado</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="max-w-lg w-full bg-white shadow-md rounded-lg p-8 text-center">
        <h1 class="text-5xl font-bold text-red-600 mb-4">403</h1>

        <h2 class="text-2xl font-semibold text-gray-800 mb-4">
            Acceso no autorizado
        </h2>

        <p class="text-gray-600 mb-6">
            No tienes permisos suficientes para acceder a esta sección.
            Esta restricción protege la información clínica de los pacientes.
        </p>

        <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-6 text-left">
            <strong>Motivo:</strong>
            el sistema detectó que tu rol no tiene autorización para consultar este recurso.
        </div>

        <a href="{{ route('dashboard') }}"
           class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Volver al dashboard
        </a>
    </div>

</body>
</html>