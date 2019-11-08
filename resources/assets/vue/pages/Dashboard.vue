<template>
    <v-container fluid>
        <v-row dense>
            <v-col cols="3" v-if="ordersCount" v-for="order in ordersCount" :key="order.id">
                <v-card class="v-card-stats">
                    <div class="v-card-header" data-background-color="green">
                        <v-icon>store</v-icon>
                    </div>
                    <div class="v-card-content">
                        <p class="category">{{ order.title }}</p>
                        <h3 class="title">{{ order.count }}</h3>
                    </div>
                    <div class="v-card-actions">
                        <v-btn color="orange" text :to="{name:'orders'}">
                            Показать
                        </v-btn>
                    </div>
                </v-card>
            </v-col>

        </v-row>
    </v-container>
</template>

<script>
    export default {
        name: 'Dashboard',
        data: () => ({
            ordersCount: []
        }),
        created() {
            this.getOrdersCount();
        },
        methods: {
            getOrdersCount() {
                axios.get('/api/orders/grouped/count')
                    .then(response => {
                        this.ordersCount = response.data;
                    });
            }
        }
    };
</script>

<style scoped>

</style>
