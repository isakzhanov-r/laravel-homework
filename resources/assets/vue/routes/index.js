import Vue from 'vue';
import VRouter from 'vue-router';
import Meta from 'vue-meta';
import web from './web';


Vue.use(VRouter);
Vue.use(Meta);

const router = new VRouter({
    mode: 'history',
    routes: web
});
router.afterEach(to => {
    router.app.$nextTick(()=>{
        document.title = to.meta.title ;
    })
});

export default router;
