window.Vue = require('vue');
import VueRouter from 'vue-router';


import Home from './components/routes/Home.vue';
import Role from './components/routes/Role.vue';
import User from './components/routes/Users.vue';



Vue.use(VueRouter);

const routes = [
    { path: '/admin', component: Home },
    { path: '/admin/role', component: Role },
    { path: '/admin/users', component: User }
];

//router assign
const routers = new VueRouter({
    mode: 'history',
    routes,
    linkExactActiveClass: "exact-active",

});

export default routers;