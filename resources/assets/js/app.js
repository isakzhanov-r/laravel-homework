/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';
import Vuetify from 'vuetify';
import DatetimePicker from 'vuetify-datetime-picker'
import router from '~/routes';
import App from '~/App';

const vuetifyOptions = {
    theme: {
        dark: true,
        themes: {
            dark: {
                background: '#272c33',
                primary: '#3F51B5',
                secondary: '#B0BEC5',
                accent: '#8C9EFF',
                error: '#B71C1C'
            },
        },
    },
    icons: {
        iconfont: 'mdiSvg', // 'mdi' || 'mdiSvg' || 'md' || 'fa' || 'fa4'
    },

};

Vue.use(Vuetify);
Vue.use(DatetimePicker);

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
    vuetify: new Vuetify(vuetifyOptions),
    ...App
}).$mount('#app');
