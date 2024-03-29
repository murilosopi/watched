import Vue from 'vue'
import Axios from 'axios'

Vue.use({
  install(Vue) {
    Vue.prototype.$api = Axios.create({
      baseURL: 'http://localhost:81',
      withCredentials: true
    });

    Vue.prototype.$api.interceptors.request.use(config => {
      if(config.method == 'post') {
        config.headers['Content-Type'] = 'application/x-www-form-urlencoded';
      }

      return config;
    });
  }
});