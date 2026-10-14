(function () {
    function bindPreview(root) {
        var inputId = root.getAttribute('data-input-id');
        if (!inputId) return;

        var input = document.getElementById(inputId);
        if (!input || input.tagName !== 'INPUT' || input.type !== 'file') return;

        var img = root.querySelector('[data-preview-img]');
        var frame = root.querySelector('.admin-image-preview__frame');
        var label = root.querySelector('.admin-image-preview__label');
        var empty = root.querySelector('[data-preview-empty]');
        var pending = root.querySelector('[data-preview-pending]');
        var objectUrl = null;

        function showImage(url) {
            if (!img) return;
            img.src = url;
            img.hidden = false;
            if (frame) frame.hidden = false;
            if (label) label.hidden = false;
            if (empty) empty.hidden = true;
        }

        function showEmpty() {
            if (img) {
                img.removeAttribute('src');
                img.hidden = true;
            }
            if (frame) frame.hidden = true;
            if (label) label.hidden = true;
            if (empty) empty.hidden = false;
            if (pending) pending.hidden = true;
        }

        input.addEventListener('change', function () {
            if (objectUrl) {
                URL.revokeObjectURL(objectUrl);
                objectUrl = null;
            }

            var file = input.files && input.files[0];
            if (!file || !file.type.startsWith('image/')) {
                if (pending) pending.hidden = true;
                return;
            }

            objectUrl = URL.createObjectURL(file);
            showImage(objectUrl);
            if (pending) pending.hidden = false;
        });
    }

    document.querySelectorAll('[data-image-preview]').forEach(bindPreview);
})();
