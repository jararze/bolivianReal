<x-app-layout>
    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">
            {{ __('Archivos Subidos') }}
        </h1>
    </x-slot>

    <div class="container-fixed">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Archivos en directorios de configuración</h3>
            </div>
            <div class="card-body">
                @foreach($files as $directory => $fileList)
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold mb-2">{{ ucfirst($directory) }}</h4>
                        @if(count($fileList) > 0)
                            <ul class="list-disc ml-6">
                                @foreach($fileList as $file)
                                    <li class="mb-1">
                                        {{ $file }}
                                        <img src="{{ asset("upload/configuration/{$directory}/{$file}") }}"
                                             alt="{{ $file }}"
                                             class="h-8 inline-block ml-2">
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">No hay archivos en este directorio</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
