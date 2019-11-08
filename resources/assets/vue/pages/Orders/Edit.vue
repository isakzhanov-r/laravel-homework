<template>

</template>

<script>
    export default {
        name: 'Edit',
        data: () => ({
            order: []
        }),
        created() {
            this.getOrder(this.$route.params.id);
        },
        methods: {
            getOrder(order_id) {
                axios.get('/api/orders/' + order_id)
                    .then(response => {
                        this.order = response.data;
                    });
            }
        }
    };
</script>

<style scoped>

</style>
