require('./bootstrap');

//Route Components
import Route from './routes.js';

var mixin = {
    methods: {
        closeModal(modal) {
            $(modal).removeClass("in");
            $(".modal-backdrop").remove();
            $("body").removeClass("modal-open");
            $("body").css("padding-right", "");
            $(modal).hide();
        },
    },
    getResults(url, page = 1) {
        axios.get(url + page).then(response => {
            this.roles = response.data;
        });
    },
}

const app = new Vue({
    el: '#app',
    router: Route,
    mixins: [mixin],
});
