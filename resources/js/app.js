import Vue from 'vue';
import App from './App.vue';
import VueRouter from 'vue-router';
import routes from './routes';

import './queries';

Vue.use(VueRouter);

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

