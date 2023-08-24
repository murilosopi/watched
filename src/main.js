import Vue from 'vue'
import App from './App.vue'
import router from './routes'
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import './plugins/axios'

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
  router
}).$mount('#app')

import 'bootstrap/dist/js/bootstrap';