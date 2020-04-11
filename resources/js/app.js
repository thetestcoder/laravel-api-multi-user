require('./bootstrap');

//Route Components
import Route from './routes.js';


const app = new Vue({
    el: '#app',
    router: Route,
});
