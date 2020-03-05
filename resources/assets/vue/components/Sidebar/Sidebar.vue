<template>
    <div class="sidebar"
         :data-color="activeColor"
         :data-image="backgroundImage"
         :style="sidebarStyle">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">
                <div class="logo-img">
                    <img :src="imgLogo" alt=""/>
                </div>
            </a>
            <router-link :to="{name:'home'}" class="simple-text logo-normal">
                {{ title }}
            </router-link>
        </div>
        <div class="sidebar-wrapper">
            <weather-widget/>
            <slot name="content"/>
            <v-list shaped class="nav">
                <v-list-group
                        v-for="(link) in routes"
                        :key="link.meta.title"
                        :prepend-icon="link.meta.icon"
                        no-action
                >
                    <template v-slot:activator>
                        <v-list-item-content>
                            <v-list-item-title v-text="link.meta.btn_name ? link.meta.btn_name: link.meta.title"></v-list-item-title>
                        </v-list-item-content>
                    </template>

                    <v-list-item
                            v-for="subItem in link.children"
                            v-if="'is_show' in subItem.meta === false"
                            :key="subItem.meta.title"
                            :to="{name:subItem.name}"
                    >
                        <v-list-item-content>
                            {{ subItem.meta.btn_name ? subItem.meta.btn_name: subItem.meta.title }}
                        </v-list-item-content>
                    </v-list-item>

                </v-list-group>
            </v-list>
        </div>
    </div>
</template>

<script>

    export default {
        name: 'Sidebar',
        props: {
            title: {
                type: String,
                default: 'Laravel'
            },
            backgroundImage: {
                type: String,
                default: require('~/../img/sidebar-2.jpg')
            },
            imgLogo: {
                type: String,
                default: require('~/../img/vue-logo.png')
            },
            activeColor: {
                type: String,
                default: 'green',
                validator: value => {
                    let acceptedValues = ['', 'purple', 'blue', 'green', 'orange', 'red'];
                    return acceptedValues.indexOf(value) !== -1;
                }
            },
            autoClose: {
                type: Boolean,
                default: true
            }
        },
        provide() {
            return {
                autoClose: this.autoClose
            };
        },
        computed: {
            sidebarStyle() {
                return {
                    backgroundImage: `url(${this.backgroundImage})`
                };
            },

            routes() {
                let _items = this.$router.options.routes;

                return _items.filter(route => {
                    if (route.meta) {
                        return ('is_show' in route.meta) === false || route.meta.is_show === true;
                    }
                });
            }
        }
    };
</script>

<style scoped>
    @media screen and (min-width: 991px) {
        .nav-mobile-menu {
            display: none;
        }
    }
</style>
