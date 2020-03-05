import Vue from 'vue';

import Sidebar from './Sidebar/Sidebar';
import TopNavbar from './Navbar/TopNavbar';
import WeatherWidget from './Weather/WeatherWidget';
import NavTabsTable from './Table/NavTabsTable';


[
    Sidebar,
    TopNavbar,
    WeatherWidget,
    NavTabsTable
].forEach(Component => {
    Vue.component(Component.name, Component);
});
