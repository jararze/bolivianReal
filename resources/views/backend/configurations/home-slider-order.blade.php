@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Sortable(document.getElementById('all-slides'), {
                animation: 150,
                handle: '.drag-handle',
                onEnd: function () {
                    saveOrder();
                }
            });

            function saveOrder() {
                const order = Array.from(document.querySelectorAll('.slide-item')).map(slide => ({
                    type: slide.dataset.type,
                    id: slide.dataset.id
                }));

                fetch('{{ route("backend.configurations.home-slider.updateOrder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({slide_order: order})
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('Orden actualizado');
                        }
                    });
            }

            function showNotification(message, type = 'success') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 p-4 rounded-lg ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white z-50`;
                notification.textContent = message;
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), 3000);
            }
        });
    </script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h1 class="font-medium text-base text-gray-900">Ordenar Slides</h1>
        <div class="flex items-center gap-1 text-sm">
            <a href="{{ route('backend.configurations.home-slider') }}" class="text-gray-700 hover:text-primary">
                Volver al Slider
            </a>
        </div>
    </x-slot>

    <div class="container-fixed">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ordenar Elementos del Slider</h3>
            </div>

            <div class="card-body p-6">
                <div id="all-slides" class="space-y-4">
                    @foreach($slides as $slide)
                        <div
                            class="slide-item flex items-center border border-gray-200 hover:border-primary/50 rounded-xl p-6 bg-white shadow-sm transition-all mb-6"
                            data-type="{{ $slide['type'] }}"
                            data-id="{{ $slide['id'] }}">

                            <div
                                class="drag-handle cursor-grab active:cursor-grabbing p-4 hover:bg-gray-50 rounded-lg mr-6">
                                <i class="fas fa-grip-vertical text-gray-400 text-xl"></i>
                            </div>

                            <div class="flex items-center flex-1 gap-6">
                                <img src="{{ $slide['image'] }}"
                                     class="w-40 h-32 object-cover rounded-lg shadow-sm"
                                     alt="{{ $slide['title'] }}">

                                <div class="flex-1">
                                    <h4 class="text-xl font-medium text-gray-900 mb-2">{{ $slide['title'] }}</h4>
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $slide['type'] === 'property' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
               {{ $slide['type'] === 'property' ? 'Propiedad' : 'Imagen Personalizada' }}
           </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
