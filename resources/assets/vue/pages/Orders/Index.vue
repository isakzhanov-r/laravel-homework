<template>
    <div class="content">
        <div class="row">
            <div class="col-12">
                <v-toolbar>
                    <v-toolbar-title>Списки заказов</v-toolbar-title>
                    <v-spacer/>
                </v-toolbar>

                <nav-tabs-table :items="orders"/>

            </div>
        </div>
        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"/>
        </v-overlay>
    </div>
</template>

<script>
    export default {
        name: 'Index',
        data: () => ({
            orders: [],
            tabs: null,
            overlay: true
        }),
        created() {
            this.getOrders();
        },
        methods: {
            async getOrders() {
                await axios.get('/api/orders')
                    .then(response => {
                        this.orders = response.data.data;
                        this.overlay = false;
                    });
            }
        }
    };
</script>

<style scoped>

</style>
