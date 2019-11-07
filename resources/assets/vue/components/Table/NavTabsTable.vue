<template>
    <div>
        <md-table v-model="items">
            <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell md-label="ID">{{ item.client_email }}</md-table-cell>
                <md-table-cell>
                    <md-button class="md-just-icon md-simple md-primary">
                        <md-icon>edit</md-icon>
                        <md-tooltip md-direction="top">Edit</md-tooltip>
                    </md-button>
                    <md-button class="md-just-icon md-simple md-danger">
                        <md-icon>close</md-icon>
                        <md-tooltip md-direction="top">Close</md-tooltip>
                    </md-button>
                </md-table-cell>
            </md-table-row>
            <md-table-pagination
                    :md-size="5"
                    :md-total="25"
                    :md-page="1"
                    md-label="Rows"
                    md-separator="of"
                    :md-page-options="[5, 10, 25]"
                    >
            </md-table-pagination>
        </md-table>
    </div>
</template>

<script>
    export default {
        name: 'nav-tabs-table',
        props: {
            items: {
                    type: Array ,
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
                selected: []
            };
        },
        methods: {
            onSelect: function (items) {
                this.selected = items;
            }
        }
    };
</script>
