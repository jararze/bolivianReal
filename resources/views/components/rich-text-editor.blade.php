<div>
    @once
        @push('styles')
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tinymce@6.3.1/skins/ui/oxide/skin.min.css">
        @endpush

        @push('scripts')
            <script src="https://cdn.tiny.cloud/1/l9tq9qj9tumh74d2l0iggmy5qr7y2hse177f6n4ltg0aiifx/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    tinymce.init({
                        selector: '#long_description',
                        plugins: 'lists link image table code emoticons',
                        toolbar: 'undo redo | formatselect | emoticons | bold italic | alignleft aligncenter alignright | bullist numlist | link image | table | code',
                        height: 400,
                        menubar: false,
                        branding: false,
                        promotion: false,
                        readonly: false,  // Explícitamente deshabilitar el modo de solo lectura
                        setup: function (editor) {
                            editor.on('init', function (e) {
                                editor.mode.set('design'); // Forzar modo de edición
                            });
                            editor.on('change', function () {
                                tinymce.triggerSave();
                            });
                        }
                    });
                });
            </script>
        @endpush
    @endonce

    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        class="tinymce-editor w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
    >{{ $value }}</textarea>
</div>
