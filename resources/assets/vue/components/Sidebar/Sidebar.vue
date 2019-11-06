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
            <md-list class="nav">
                <slot>
                    <sidebar-link
                            v-for="(link, index) in sidebarLinks"
                            :key="link.name + index"
                            :to="link.path"
                            :link="link">
                    </sidebar-link>
                </slot>
            </md-list>
        </div>
    </div>
</template>

<script>
    import SidebarLink from './SidebarLink.vue';

    export default {
        name: 'Sidebar',
        components: {
            SidebarLink
        },
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
            sidebarLinks: {
                type: Array,
                default: () => []
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
