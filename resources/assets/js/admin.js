let forms = document.getElementsByTagName('form');
Array.from(forms).forEach((form) => {
    form.addEventListener('submit', event => {
        if (typeof form.dataset['warning'] !== 'undefined') {
            if (!confirm(form.dataset['warning'])) {
                event.preventDefault();
            }
        }
    });
});