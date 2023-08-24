import Vue from 'vue'
import Axios from 'axios'

Vue.use({
  install(Vue) {
    Vue.prototype.$api = Axios.create({
      baseURL: 'http://localhost'
    });
  }
});