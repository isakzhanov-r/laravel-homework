<template>
    <li class="md-list-item">
        <router-link
                class="md-list-item-router md-list-item-container md-button-clean"
                @click="hideSidebar"
                v-bind="$attrs"
                :to="{name:link.name}"
        >
            <div class="md-list-item-content md-ripple">
                <slot>
                    <v-icon>{{ link.icon }}</v-icon>
                    <p>{{ link.title }}</p>
                </slot>
            </div>
        </router-link>
    </li>
</template>

<script>
    export default {
        name: 'SidebarLink',
        inject: {
            autoClose: {
                default: true
            }
        },
        props: {
            link: {
                type: [String, Object],
                default: () => {
                    return {
                        name: '',
                        title: '',
                        path: '',
                        icon: ''
                    };
                }
            },
            tag: {
                type: String,
                default: 'router-link'
            }
        },
        methods: {
            hideSidebar() {
                if (
                    this.autoClose &&
                    this.$sidebar &&
                    this.$sidebar.showSidebar === true
                ) {
                    this.$sidebar.displaySidebar(false);
                }
            }
        }
    };
</script>

<style scoped>

</style>
