<template>
    <v-app>
        <div class="wrapper" :class="{ 'nav-open': $root.sidebarStore.showSidebar }">
            <sidebar></sidebar>
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
