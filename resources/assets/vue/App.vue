<template>
    <v-app>
        <div class="wrapper" :class="{ 'nav-open': $root.sidebarStore.showSidebar }">
            <sidebar>
                <sidebar-link :link="{name:'home',title:'Главная',icon:'dashboard'}"/>
                <sidebar-link :link="{name:'orders',title:'Заказы',icon:'content_paste'}"/>
                <sidebar-link :link="{name:'products',title:'Продукты',icon:'shopping_cart'}"/>
            </sidebar>
            <div class="main-panel">
                <top-navbar/>
                <transition mode="out-in">
                    <router-view :key="$route.path"/>
                </transition>
            </div>
            <router-view name="footer"/>
        </div>
    </v-app>
</template>

<script>
    export default {
        name: 'App'
    };
</script>

<style scoped>

</style>
