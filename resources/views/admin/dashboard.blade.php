<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel de Administrador
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Bienvenido, administrador</h3>

                    <p>
                        Esta vista está protegida para usuarios con rol <strong>admin</strong>.
                    </p>

                    <p class="mt-4">
                        El administrador puede consultar información general de los pacientes,
                        pero no puede ver datos clínicos sensibles como diagnóstico completo,
                        tratamiento ni notas médicas.
                    </p>

                    <div class="mt-6 p-4 bg-yellow-100 rounded">
                        <strong>Restricción aplicada:</strong>
                        esta vista muestra datos administrativos limitados.
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Pacientes registrados</h3>

                    <table class="w-full border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100 border-b">
                                <th class="text-left p-2">Documento</th>
                                <th class="text-left p-2">Nombre</th>
                                <th class="text-left p-2">Fecha de nacimiento</th>
                                <th class="text-left p-2">Acción</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($patients as $patient)
                                <tr class="border-b">
                                    <td class="p-2">{{ $patient->document_number }}</td>
                                    <td class="p-2">{{ $patient->full_name }}</td>
                                    <td class="p-2">{{ $patient->birth_date }}</td>
                                    <td class="p-2">
                                        <a href="{{ route('patients.show', $patient) }}"
                                           class="text-blue-600 underline">
                                            Ver perfil limitado
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if ($patients->isEmpty())
                        <p class="mt-4 text-gray-600">
                            No hay pacientes registrados.
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>