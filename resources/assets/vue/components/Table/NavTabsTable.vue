<template>
    <v-card>
        <v-data-table
                :headers="headers"
                :items="items"
                item-key="id"
                :items-per-page="25"
                :footer-props="{itemsPerPageText : 'Колличество на странице', itemsPerPageOptions : [10,25,50]}"
                :single-expand="singleExpand"
                :expanded.sync="expanded"
                show-expand
                class="elevation-1">
            <template v-slot:item.price="{ item }">
                {{ sumProducts(item.products) }} P.
            </template>
            <template v-slot:item.status="{ item }">
                <v-chip v-if="item.status === 0" class="ma-2" color="green" text-color="white">новый</v-chip>
                <v-chip v-if="item.status === 10" class="ma-2" color="primary" text-color="white">подтвержден
                    <v-icon right>keyboard_arrow_down</v-icon>
                </v-chip>
                <v-chip v-if="item.status === 20" class="ma-2" color="orange" text-color="white">завершен
                    <v-icon right>star</v-icon>
                </v-chip>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-btn :to="{name: 'orders.edit', params: {id: item.id}}" text>
                    <v-icon>edit</v-icon>
                </v-btn>

                <v-btn @click="destroy(item.id)" text>
                    <v-icon>delete</v-icon>
                </v-btn>
            </template>
            <template v-slot:expanded-item="{ headers, item }">
                <td :colspan="headers.length">Продукты: {{ productsName(item.products) }}</td>
            </template>

        </v-data-table>
    </v-card>
</template>

<script>
    export default {
        name: 'nav-tabs-table',
        props: {
            items: {
                type: [Array, Object],
                default: []
            },
            edit: {
                type: Boolean,
                default: true
            },
            delete: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                selected: [],
                expanded: [],
                singleExpand: false,
                headers: [
                    {text: 'ID', value: 'id'},
                    {text: 'Партнер', value: 'partner.name'},
                    {text: 'Стоимость', value: 'price'},
                    {text: 'Статус', value: 'status'},
                    {text: 'Дата доставки', value: 'delivery_at'},
                    {text: 'Действие', value: 'actions', sortable: false}
                ],
                itemsPerPageOptions: [
                    10, 25, 50, -1
                ]
            };
        },
        methods: {
            onSelect: function (items) {
                this.selected = items;
            },

            sumProducts(products) {
                var sum = 0;
                products.forEach(product => {
                    sum = sum + (product.price * product.pivot.quantity);
                });
                return sum;
            },
            productsName(products) {
                var names = products.map(product => {
                    return product.name;
                });
                return names.join(' , ');
            },

            destroy(order_id) {
                axios.delete('/api/orders/' + order_id).then(response => {
                    let order = this.items.find(item => item.id === order_id);
                    let index = this.items.indexOf(order);
                    this.items.splice(index, 1);
                });
            }

        }
    };
</script>
