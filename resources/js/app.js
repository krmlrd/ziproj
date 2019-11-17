import Vue from 'vue'
import Vuetify from 'vuetify'
import VueRouter from 'vue-router'
import 'es6-promise/auto'
import axios from 'axios'
import './bootstrap'
import Index from './Index'
import routes from '@/js/routes.js';
import { store } from './store/store'

window.eventBus = new Vue()

Vue.use(Vuetify)

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
)

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
)

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
)

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!store.getters.loggedIn) {
      next({
        name: 'login',
      })
    } else {
      next()
    }
  } else if (to.matched.some(record => record.meta.requiresVisitor)) {
    if (store.getters.loggedIn) {
      next({
        name: 'dashboard',
      })
    } else {
      next()
    }
  } else {
    next()
  }
})

Vue.axios = axios
axios.defaults.baseURL = `/api/auth`

const vuetifyOptions = {}

const app = new Vue({
    vuetify: new Vuetify(vuetifyOptions),
    render: h => h(Index),
    store: store,
    router: router
}).$mount('#app');

export default app;
