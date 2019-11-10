<template>
    <div class="content">
        <div class="row">
            <div class="col-12">
                <v-toolbar>
                    <v-toolbar-title>Списки продуктов</v-toolbar-title>
                    <v-spacer/>
                </v-toolbar>

                <v-card>
                    <v-data-table
                            :headers="headers"
                            :items="products"
                            item-key="id"
                            :items-per-page="25"
                            :footer-props="{itemsPerPageText : 'Колличество на странице', itemsPerPageOptions : [10,25,50]}"
                            class="elevation-1">
                        <template v-slot:item.price="props">
                            <v-edit-dialog
                                    :return-value.sync="props.item.price"
                                    @open="open(props.item.price)"
                                    @save="save(props.item)"
                            > {{ props.item.price }}
                                <template v-slot:input>
                                    <v-text-field
                                            v-model="props.item.price"
                                            label="Edit"
                                            type="number"
                                            :minlength="1"
                                            single-line
                                            counter
                                    ></v-text-field>
                                </template>
                            </v-edit-dialog>
                        </template>
                    </v-data-table>
                </v-card>
            </div>
        </div>
    </div>
</template>

<script>
    import Form from 'vform';

    export default {
        name: 'Index',
        data: () => ({
            dialog: false,
            snack: false,
            snackColor: '',
            snackText: '',
            headers: [
                {text: 'ID', value: 'id'},
                {text: 'Наименование', value: 'name'},
                {text: 'Стоимость', value: 'price'},
                {text: 'Поставщик', value: 'vendor.name'}
            ],
            form: new Form({
                price: 0,
                name: '',
                vendor_id: null
            }),
            originalValue: 0,
            products: []
        }),
        created() {
            this.getProducts();
        },
        methods: {
            getProducts() {
                axios.get('/api/products')
                    .then(response => {
                        this.products = response.data;
                    });
            },
            open(price) {
                this.originalValue = price;
            },
            save(item) {
                let $index = this.products.indexOf(item);
                this.form.vendor_id = item.vendor_id;
                this.form.name = item.name;
                this.form.price = item.price;
                this.form.put('/api/products/' + item.id)
                    .then()
                    .catch(e => {
                        this.products.find((item, index) => {
                            if (index === $index) {
                                item.price = this.originalValue;
                            }
                        });
                        this.errors = e.response.data.message || e.message;
                    });
            }
        }
    };
</script>

<style scoped>

</style>
