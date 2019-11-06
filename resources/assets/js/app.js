/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';
import VueMaterial from 'vue-material';
import router from '~/routes';
import App from '~/App';

Vue.use(VueMaterial);

const SidebarStore = {
    showSidebar: false,
    displaySidebar(value) {
        this.showSidebar = value;
    }
};

import '~/components';
import './bootstrap';

Vue.mixin({
    data() {
        return {
            sidebarStore: SidebarStore
        };
    }
});

new Vue({
    router,
    ...App
}).$mount('#app');
