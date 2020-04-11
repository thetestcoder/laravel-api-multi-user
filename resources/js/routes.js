window.Vue = require('vue');
import VueRouter from 'vue-router';


import Home from './components/routes/Home.vue';
import Role from './components/routes/Role.vue';

Vue.use(VueRouter);

const routes = [
    { path: '/admin', component: Home },
    { path: '/admin/role', component: Role }
];


//router assign
const routers = new VueRouter({
    mode: 'history',
    routes
});

export default routers;