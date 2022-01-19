import Vue from 'vue';
import App from './App.vue';
import VueRouter from 'vue-router';
import routes from './routes';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import VueSweetAlert2 from 'vue-sweetalert2';



import './queries';
import './../sass/app.scss';
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueRouter);
Vue.use(BootstrapVue)
Vue.use(VueSweetAlert2);

const router = new VueRouter({
    routes,
    mode: 'history',
})

router.beforeEach((to, from, next) => {
    if(to.matched.some(m=>m.meta.isAdmin === false)) {
        next();
        return;
    }
    next();
    return;
})

new Vue ({
    router,
    render: h=> h(App)
}).$mount('#app');

