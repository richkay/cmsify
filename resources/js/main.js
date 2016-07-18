import Vue from 'vue';
import VueRouter from 'vue-router';
import VueResource from 'vue-resource';
import moment from 'momentjs';

Vue.use(VueRouter);
Vue.use(VueResource);
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

Vue.filter('moment', function (date, format) {
    return moment(date).format(format);
});
Vue.filter('chunk', function (array, length) {
    var totalChunks = [];
    var chunkLength = parseInt(length);
    for (var i = 0; i < array.length; i += chunkLength) {
        totalChunks.push(array.slice(i, i + chunkLength));
    }
    return totalChunks;
});

var App = Vue.extend({

    data() {
        return {}
    },

    computed: {
        loggedIn() {
            return true;
        }
    },

    components: {},

    methods: {},

    events: {}

});


var router = new VueRouter();
router.map({
    '/': {
        name: 'dashboard',
        component: require('./DashboardView.vue')
    },
    '/pages': {
        name: 'pages',
        component: require('./PagesView.vue'),
        subRoutes: {
            '/': {
                component: require('./pages/index.vue')
            },
            '/create': {
                name: 'page_create',
                component: require('./pages/create.vue')
            },
            '/edit/:id': {
                name: 'page_edit',
                component: require('./pages/edit.vue')
            }
        },
    },
});

router.start(App, '#cmsify');
