import Vue from 'vue'
import App from './App.vue'
import router from './routes'
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import './plugins/axios'
import 'animate.css';
import store from './store';
import AuthMixin from './mixins/AuthMixin';
import NotificationMixin from './mixins/NotificationMixin';
import ChatMixin from './mixins/ChatMixin';

Vue.config.productionTip = false

Vue.mixin(NotificationMixin);
Vue.mixin(AuthMixin);
Vue.mixin(ChatMixin);

new Vue({
  render: h => h(App),
  router,
  store
}).$mount('#app')


import 'bootstrap/dist/js/bootstrap';