<template>
    <md-toolbar md-elevation="0" class="md-transparent">
        <div class="md-toolbar-row">
            <div class="md-toolbar-section-start">
                <h3 class="md-title">{{ $route.meta.title }}</h3>
            </div>
        </div>
    </md-toolbar>
</template>

<script>
    export default {
        name: 'TopNavbar',
        data: () => ({}),
        methods: {
            toggleSidebar() {
                this.$root.sidebarStore.displaySidebar(!this.$root.sidebarStore.showSidebar);
            }
        }
    };
</script>

