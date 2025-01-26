@push('scripts')
    <script>
        window.showLoading = function() {
            alert("entro")

            document.getElementById('loading-modal').classList.remove('hidden');
        }

        window.hideLoading = function() {
            document.getElementById('loading-modal').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Para formularios
            const forms = document.querySelectorAll('form');
            alert(forms)
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    alert("dsadsa")
                    showLoading();
                });
            });
        });

        // Para peticiones AJAX con Laravel
        document.addEventListener('ajax:send', () => showLoading());
        document.addEventListener('ajax:complete', () => hideLoading());

        // Interceptar Fetch
        let originalFetch = window.fetch;
        window.fetch = function() {
            showLoading();
            return originalFetch.apply(this, arguments)
                .then(function(response) {
                    hideLoading();
                    return response;
                })
                .catch(function(error) {
                    hideLoading();
                    throw error;
                });
        }

        // Interceptar Axios (que es lo que usa Laravel por defecto)
        window.axios.interceptors.request.use(function (config) {
            showLoading();
            return config;
        }, function (error) {
            hideLoading();
            return Promise.reject(error);
        });

        window.axios.interceptors.response.use(function (response) {
            hideLoading();
            return response;
        }, function (error) {
            hideLoading();
            return Promise.reject(error);
        });
    </script>
@endpush

<div id="loading-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white p-5 rounded-lg flex flex-col items-center">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-primary"></div>
        <p class="mt-4 text-gray-700">Procesando...</p>
    </div>
</div>


