import Vue from 'vue'
import App from './App.vue'
import Router from './routes.js'
import VeeValidate from 'vee-validate'
import VueResource from 'vue-resource'
import BootstrapVue from 'bootstrap-vue'
import jquery from 'jquery';
import Auth from './packages/auth/Auth.js'
import InstantSearch from 'vue-instantsearch'
import VueObserveVisibility from 'vue-observe-visibility'
import moment from 'moment'
import proxy from 'http-proxy-middleware'
import VueSocketIo from 'vue-socket.io'



Vue.use(VueResource)
Vue.use(Auth)
Vue.use(VeeValidate)
Vue.use(BootstrapVue)
Vue.use(InstantSearch)
Vue.use(VueObserveVisibility)
Vue.use(VueSocketIo, `${location.protocol}//${location.hostname}:8001`);
// Vue.use(VueSocketIo, `${location.protocol}//${location.hostname}/app2`);
// Vue.use('/api/*', proxy({target: 'http://localhost:8000', secure: false, changeOrigin: true}))


// Vue.http.options.root = `${location.protocol}//${location.hostname}:8000`;
// Vue.http.options.root = 'http://localhost:8000';
Vue.http.headers.common['Authorization'] = 'Bearer ' + Vue.auth.getToken();


Vue.component('wysiwyg', require('./components/community/wysiwyg.vue'));
Vue.component('replies', require('./components/community/replies.vue'));
Vue.component('paginator', require('./components/community/paginator.vue'));
Vue.component('user-notifications', require('./components/community/UserNotifications.vue'));

Vue.prototype.authorize = function(handler) {
    let user = window.App.user;

    return user ? handler(user) : false;
}


Vue.http.interceptors.push((request, next) => {
    next(response => {
        if (response.status == 404) {
            swal("Succesfully Updated!", {
                title: 'Error ' + response.status,
                text: response.body.error,
                icon: "error",
            });
        } else if (response.status == 500)
            console.log("There's a problem in the server")
            // swal("Succesfully Updated!", {
            //   title: 'Error ' + response.status,
            //   text: "There's a problem in the server",
            //   icon: "error",
            // });
    })
})

Router.beforeEach(
    (to, from, next) => {
        if (to.matched.some(record => record.meta.forVisitors)) {
            if (Vue.auth.isAuthenticated()) {
                next({
                    path: '/'
                })
            } else next()
        } else if (to.matched.some(record => record.meta.forAuth)) {
            if (!Vue.auth.isAuthenticated()) {
                next({
                    path: '/discover'
                })
            } else next()
        } else next()
    }
)

Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).fromNow()
    }
})
Vue.filter('formatDateFormal', function(value) {
    if (value) {
        return moment(String(value)).format('MM/DD/YYYY hh:mm')
    }
})


new Vue({
    el: '#app',
    render: h => h(App),
    router: Router
})