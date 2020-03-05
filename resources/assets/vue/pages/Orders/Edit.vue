<template>
    <v-container>
        <v-card class="v-card-md">
            <div class="v-card-header">
                <h4 class="title">Заказ №{{ form.id }}</h4>
            </div>
            <v-card-text>
                <v-row>
                    <v-col cols="4">
                        <v-text-field v-model="form.client_email" label="E-Mail Клиента"
                                      :error=" form.errors.get('client_email') ? true : false"
                                      :error-messages=" form.errors.get('client_email')"/>
                    </v-col>
                    <v-col cols="4">
                        <v-select v-model="form.status" :items="statuses" label="Статус" item-text="title" item-value="status"
                                  :error=" form.errors.get('status') ? true : false"
                                  :error-messages=" form.errors.get('status')" required/>
                    </v-col>
                    <v-col cols="4">
                        <v-select v-model="form.partner_id"
                                  :items="partners"
                                  label="Партнер"
                                  item-text="name"
                                  item-value="id"
                                  :error=" form.errors.get('partner_id') ? true : false"
                                  :error-messages=" form.errors.get('partner_id')" required/>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col cols="12">
                        <v-datetime-picker label="Дата доставки" v-model="deliveryAt" format="24hr"></v-datetime-picker>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col cols="12">
                        <v-card class="v-card-md">
                            <div class="v-card-header">
                                <h4 class="title">Список продуктов</h4>
                            </div>
                            <v-card-text>
                                <v-data-table
                                        :headers="tables.products.headers"
                                        :items="form.products"
                                        :hide-default-footer="true"
                                >
                                    <template v-slot:item.price="{ item }">
                                        {{ item.price }}
                                    </template>

                                    <template v-slot:item.priceForAll="{ item }">
                                        {{ item.price * item.pivot.quantity }}
                                    </template>

                                    <template v-slot:item.pivot.quantity="{ item }">
                                        <v-btn text icon @click="orderProductQuantityDecrement(item)" :disabled="item.pivot.quantity === 1">
                                            <v-icon>remove</v-icon>
                                        </v-btn>

                                        {{ item.pivot.quantity }}

                                        <v-btn text icon @click="orderProductQuantityIncrement(item)">
                                            <v-icon>add</v-icon>
                                        </v-btn>
                                    </template>

                                    <template v-slot:item.actions="{ item }">
                                        <v-btn text icon @click="deleteOrderProduct(item)">
                                            <v-icon>delete</v-icon>
                                        </v-btn>
                                    </template>

                                    <template v-slot:footer>
                                        <div class="text-right">
                                            <v-chip>Итого : {{ orderProductsSum() }}</v-chip>
                                            <v-dialog v-model="dialog" max-width="500px">
                                                <template v-slot:activator="{ on }">
                                                    <v-btn v-on="on" color="deep-purple" text icon>
                                                        <v-icon>add</v-icon>
                                                    </v-btn>
                                                </template>

                                                <v-card>
                                                    <v-card-title>
                                                        <span class="headline">Добавить продукт к заказу</span>
                                                    </v-card-title>

                                                    <v-card-text>
                                                        <v-row>
                                                            <v-col cols="8">
                                                                <v-select
                                                                        v-model="addProduct.id"
                                                                        :items="products"
                                                                        label="Продукты"
                                                                        item-text="name"
                                                                        item-value="id"
                                                                        required
                                                                >
                                                                    <template v-slot:item="{ item }">
                                                                        {{ item.name }}
                                                                        <v-spacer/>
                                                                        <span class="deep-purple--text text--lighten-4">{{ item.price }}</span>
                                                                    </template>
                                                                </v-select>
                                                            </v-col>
                                                            <v-col cols="4">
                                                                <v-text-field v-model="addProductQuantity" label="Колличество" type="number" min="1"
                                                                              required/>
                                                            </v-col>
                                                        </v-row>
                                                    </v-card-text>

                                                    <v-card-actions>
                                                        <span class="green--text">{{ addProductSum() }}</span>

                                                        <v-spacer/>

                                                        <v-btn color="deep-purple darken-1" @click="closeDialog()" text v-text="'Закрыть'"/>
                                                        <v-btn color="deep-purple darken-1" @click="addProductToOrder" text v-text="'Сохранить'"/>
                                                    </v-card-actions>
                                                </v-card>
                                            </v-dialog>
                                        </div>
                                    </template>

                                </v-data-table>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col cols="12">
                        <v-btn class="md-raised md-success" @click="updateOrder">Сохранить</v-btn>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"/>
        </v-overlay>
    </v-container>
</template>

<script>
    import * as moment from 'moment';
    import Form from 'vform';

    export default {
        name: 'Edit',
        data: () => ({
            dialog: false,
            overlay: true,
            errors: null,
            products: [],
            partners: [],
            form: new Form({
                id: null,
                client_email: null,
                status: null,
                delivery_at: null,
                partner_id: null,
                products: []
            }),
            addProduct: {
                id: null,
                quantity: 1,
                item: {}
            },
            statuses: [
                {status: 0, title: 'новый'},
                {status: 10, title: 'подтвержден'},
                {status: 20, title: 'завершен'}
            ],
            tables: {
                products: {
                    headers: [
                        {text: 'Название', value: 'name'},
                        {text: 'Цена', value: 'price'},
                        {text: 'Колличество', value: 'pivot.quantity'},
                        {text: 'Итого', value: 'priceForAll'},
                        {text: 'Действия', value: 'actions'}
                    ]
                }
            }
        }),
        computed: {
            deliveryAt: {
                get() {
                    return new Date(this.form.delivery_at);
                },
                set(value) {
                    this.form.delivery_at = moment(value).format('YYYY-MM-DD HH:mm:ss');
                }
            },
            addProductQuantity: {
                get() {
                    return this.addProduct.quantity;
                },

                set(value) {
                    this.addProduct.quantity = parseInt(value);
                }
            }
        },
        created() {
            this.getOrder(this.$route.params.id);
            this.getPartners();
            this.getProducts();
        },
        methods: {
            getOrder(order_id) {
                axios.get('/api/orders/' + order_id)
                    .then(response => {
                        var data = response.data.data;
                        this.form.id = data.id;
                        this.form.client_email = data.client_email;
                        this.form.status = data.status;
                        this.form.delivery_at = data.delivery_at;
                        this.form.partner_id = data.partner_id;
                        this.form.products = data.products;
                        this.overlay = false;
                    });
            },
            getProducts() {
                axios.get('/api/products')
                    .then(response => {
                        this.products = response.data.data;
                    });

            },
            getProductById(id, items = null) {
                items = items === null ? this.products : items;
                return items.find(product => {
                    return product.id === id;
                });
            },
            addProductToOrder() {
                var productId = this.addProduct.id;
                var quantity = this.addProduct.quantity;
                var formProduct = this.getProductById(productId, this.form.products);
                if (formProduct) {
                    formProduct.pivot.quantity = formProduct.pivot.quantity + quantity;
                } else {
                    var product = this.getProductById(productId);
                    if (product) {
                        var toFormProduct = Object.assign({}, product);
                        toFormProduct.pivot = {
                            price: toFormProduct.price,
                            quantity: quantity
                        };
                        this.form.products.push(toFormProduct);
                    }
                }
                this.closeDialog();
            },
            updateOrder() {
                var $this = this;
                $this.overlay = true;
                this.form.put('/api/orders/' + this.$route.params.id)
                    .then()
                    .catch(e => {
                        this.errors = e.response.data.message || e.message;
                    })
                    .finally(function () {
                        $this.overlay = false;
                    });
            },
            getPartners() {
                axios.get('/api/partners')
                    .then(response => {
                        this.partners = response.data.data;
                    });

            },
            orderProductsSum() {
                var products = this.form.products;
                var sum = 0;
                if (products) {
                    products.forEach(product => {
                        sum = sum + (product.price * product.pivot.quantity);
                    });
                }
                return sum;
            },
            deleteOrderProduct(item) {
                let $index = this.form.products.indexOf(item);

                this.form.products.splice($index, 1);
            },
            orderProductQuantityIncrement(item) {
                let quantity = item.pivot.quantity;

                let $index = this.form.products.indexOf(item);
                this.form.products.find((item, index) => {
                    if (index === $index) {
                        item.pivot.quantity = quantity + 1;
                    }
                });
            },
            orderProductQuantityDecrement(item) {
                let quantity = item.pivot.quantity;

                let $index = this.form.products.indexOf(item);

                quantity = quantity - 1 < 1 ? 1 : quantity - 1;

                this.form.products.find((item, index) => {
                    if (index === $index) {
                        item.pivot.quantity = quantity;
                    }
                });
            },
            addProductSum() {
                var price = 0;
                var id = this.addProduct.id;
                var quantity = this.addProduct.quantity;
                var product = this.getProductById(id);
                if (product) {
                    price = product.price;
                }

                return price * quantity;
            },
            closeDialog() {
                this.addProduct.id = null;
                this.addProduct.quantity = 1;
                this.dialog = false;
            }
        }
    };
</script>

<style scoped>

</style>
