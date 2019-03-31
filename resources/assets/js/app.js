/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
setInterval(() => {
    document.body.innerHTML = document.body.innerHTML.replace('Salve Mundi', 'Innovum');
    document.body.innerHTML = document.body.innerHTML.replace('ICT', 'Engineering');
}, 2500);