import Vue from 'vue'
import './plugins/axios'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify';
import VueCurrencyFilter from './plugins/vueCurrencyFilter'

Vue.config.productionTip = false

new Vue({
  router,
  store,
  vuetify,
  VueCurrencyFilter,
  render: h => h(App)
}).$mount('#app')
