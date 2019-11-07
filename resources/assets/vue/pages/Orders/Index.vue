<template>
    <div class="content">
        <div class="layout">
            <md-tabs class="md-success" md-alignment="centered" v-if="orders">
                <md-tab v-for="order in orders" :key="order.id" :id="'tab-'+order.id" :md-label="order.title">
                    <md-card>
                        <md-card-header data-background-color="green">
                            <h4 class="title">{{ order.title }}</h4>
                        </md-card-header>
                        <md-card-content>
                            <nav-tabs-table :items="order.items"/>
                        </md-card-content>
                    </md-card>
                </md-tab>
            </md-tabs>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Index',
        data: () => ({
            orders: []
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
