<template>
    <div class="content">
        <div class="row">
            <div class="col-12">
                <v-toolbar>
                    <v-toolbar-title>Списки заказов</v-toolbar-title>
                    <v-spacer/>
                    <template v-slot:extension>
                        <v-tabs v-model="tabs" fixed-tabs>
                            <v-tabs-slider/>
                            <v-tab class="primary--text" v-for="order in orders" :key="'tab-'+order.id" :href="'#tabs-'+order.id">
                                {{ order.title }}
                            </v-tab>
                        </v-tabs>
                    </template>
                </v-toolbar>
                <v-tabs-items v-model="tabs">
                    <v-tab-item v-for="order in orders" :key="'item-'+order.id" :value="'tabs-' + order.id">
                        <nav-tabs-table :items="order.items"/>
                    </v-tab-item>
                </v-tabs-items>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Index',
        data: () => ({
            orders: [],
            tabs: null
        }),
        created() {
            this.getOrders();
        },
        methods: {
            async getOrders() {
                await axios.get('/api/orders/grouped')
                    .then(response => {
                        this.orders = response.data;
                    });
            }
        }
    };
</script>

<style scoped>

</style>
