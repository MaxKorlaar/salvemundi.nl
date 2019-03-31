/**
 * Door het opgeven van 'autoload' in webpack.mix.js is het niet nodig om in dit bestand jQuery, Popper en Bootstrap te laden en globaal te maken.
 */


/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF Missing');
}
setInterval(() => {
    if (document.body.innerHTML.indexOf('Salve Mundi') !== -1) {
        document.body.innerHTML = document.body.innerHTML.replace('Salve Mundi', 'Innovum');
        document.body.innerHTML = document.body.innerHTML.replace('ICT', 'Engineering');
    }
}, 2500);