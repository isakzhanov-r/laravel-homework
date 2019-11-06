import Vue from 'vue';

import Sidebar from './Sidebar/Sidebar';
import SidebarLink from './Sidebar/SidebarLink';
import TopNavbar from './Navbar/TopNavbar';
import WeatherWidget from './Weather/WeatherWidget';

[
    Sidebar,
    SidebarLink,
    TopNavbar,
    WeatherWidget
].forEach(Component => {
    Vue.component(Component.name, Component);
});
