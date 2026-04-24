<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Perfil del Paciente
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-2xl font-bold mb-6">
                        {{ $patient->full_name }}
                    </h3>

                    <div class="mb-6 p-4 bg-blue-100 rounded">
                        <strong>Rol actual:</strong> {{ Auth::user()->role }}
                    </div>

                    <h4 class="text-lg font-bold mb-3">Información general</h4>

                    <table class="w-full border border-gray-300 mb-6">
                        <tr class="border-b">
                            <th class="text-left p-2 bg-gray-100">Documento</th>
                            <td class="p-2">{{ $patient->document_number }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="text-left p-2 bg-gray-100">Nombre completo</th>
                            <td class="p-2">{{ $patient->full_name }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="text-left p-2 bg-gray-100">Fecha de nacimiento</th>
                            <td class="p-2">{{ $patient->birth_date }}</td>
                        </tr>
                    </table>

                    @if (Auth::user()->role === 'admin')
                        <div class="p-4 bg-yellow-100 rounded mb-6">
                            <h4 class="font-bold mb-2">Vista limitada para administrador</h4>
                            <p>
                                El administrador puede consultar información básica del paciente,
                                pero no puede ver diagnóstico, tratamiento ni notas médicas.
                            </p>
                        </div>

                        <table class="w-full border border-gray-300">
                            <tr class="border-b">
                                <th class="text-left p-2 bg-gray-100">Teléfono</th>
                                <td class="p-2">{{ $patient->phone }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="text-left p-2 bg-gray-100">Correo</th>
                                <td class="p-2">{{ $patient->email }}</td>
                            </tr>
                            <tr>
                                <th class="text-left p-2 bg-gray-100">Dirección</th>
                                <td class="p-2">Información restringida</td>
                            </tr>
                        </table>
                    @endif

                    @if (Auth::user()->role === 'doctor')
                        <div class="p-4 bg-green-100 rounded mb-6">
                            <h4 class="font-bold mb-2">Vista completa para doctor</h4>
                            <p>
                                El doctor puede consultar información clínica protegida del paciente.
                            </p>
                        </div>

                        <h4 class="text-lg font-bold mb-3">Información de contacto</h4>

                        <table class="w-full border border-gray-300 mb-6">
                            <tr class="border-b">
                                <th class="text-left p-2 bg-gray-100">Teléfono</th>
                                <td class="p-2">{{ $patient->phone }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="text-left p-2 bg-gray-100">Correo</th>
                                <td class="p-2">{{ $patient->email }}</td>
                            </tr>
                            <tr>
                                <th class="text-left p-2 bg-gray-100">Dirección</th>
                                <td class="p-2">{{ $patient->address }}</td>
                            </tr>
                        </table>

                        <h4 class="text-lg font-bold mb-3">Información clínica protegida</h4>

                        <table class="w-full border border-gray-300">
                            <tr class="border-b">
                                <th class="text-left p-2 bg-gray-100">Tipo de sangre</th>
                                <td class="p-2">{{ $patient->blood_type }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="text-left p-2 bg-gray-100">Diagnóstico</th>
                                <td class="p-2">{{ $patient->diagnosis }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="text-left p-2 bg-gray-100">Tratamiento</th>
                                <td class="p-2">{{ $patient->treatment }}</td>
                            </tr>
                            <tr>
                                <th class="text-left p-2 bg-gray-100">Notas médicas</th>
                                <td class="p-2">{{ $patient->medical_notes }}</td>
                            </tr>
                        </table>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('dashboard') }}" class="text-blue-600 underline">
                            Volver al dashboard
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>