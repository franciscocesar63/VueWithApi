import Vue from 'vue'
import VueRouter from 'vue-router'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import App from './App.vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import CrudHello from '@/components/CrudHello'

Vue.config.productionTip = false

Vue.use(VueRouter)
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

const router = new VueRouter({
  routes: [
    {
      path: '/cadastro',
      component: CrudHello
    },
    {
      path: '/',
      redirect: '/cadastro'
  
    }

  ]

});

new Vue({
  router,
  render: h => h(App),
}).$mount('#app')
