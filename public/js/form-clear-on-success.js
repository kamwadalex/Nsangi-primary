(function () {
    var forms = document.querySelectorAll('form[data-clear-on-success]');
    if (!forms.length) return;

    var hasSuccess = !!document.querySelector('.alert-success');

    forms.forEach(function (form) {
        if (hasSuccess) {
            form.reset();
            form.querySelectorAll('input[type="file"]').forEach(function (input) {
                input.value = '';
            });
        }

        form.addEventListener('submit', function () {
            var buttons = form.querySelectorAll('button[type="submit"], input[type="submit"]');
            buttons.forEach(function (button) {
                button.disabled = true;
                if (button.tagName === 'BUTTON' && !button.dataset.originalText) {
                    button.dataset.originalText = button.textContent;
                    button.textContent = 'Sending…';
                }
            });
        });
    });
})();
