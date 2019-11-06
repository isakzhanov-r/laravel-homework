window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.token = document.head.querySelector('meta[name="csrf-token"]');


try {
    window._ = require('lodash');
    window.$ = window.jQuery = require('jquery');
} catch (e) {}

