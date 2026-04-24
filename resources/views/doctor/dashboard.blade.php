<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel del Doctor
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Bienvenido, doctor</h3>

                    <p>
                        Esta vista está protegida para usuarios con rol <strong>doctor</strong>.
                    </p>

                    <p class="mt-4">
                        El doctor puede acceder a información clínica protegida de los pacientes,
                        incluyendo diagnóstico, tratamiento y notas médicas.
                    </p>

                    <div class="mt-6 p-4 bg-green-100 rounded">
                        <strong>Restricción aplicada:</strong>
                        esta vista muestra información clínica autorizada solo para doctores.
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Pacientes asignados</h3>

                    <table class="w-full border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100 border-b">
                                <th class="text-left p-2">Documento</th>
                                <th class="text-left p-2">Nombre</th>
                                <th class="text-left p-2">Fecha de nacimiento</th>
                                <th class="text-left p-2">Diagnóstico</th>
                                <th class="text-left p-2">Acción</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($patients as $patient)
                                <tr class="border-b">
                                    <td class="p-2">{{ $patient->document_number }}</td>
                                    <td class="p-2">{{ $patient->full_name }}</td>
                                    <td class="p-2">{{ $patient->birth_date }}</td>
                                    <td class="p-2">{{ $patient->diagnosis }}</td>
                                    <td class="p-2">
                                        <a href="{{ route('patients.show', $patient) }}"
                                           class="text-blue-600 underline">
                                            Ver perfil clínico
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