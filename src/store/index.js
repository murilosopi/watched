import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import auth from './modules/auth';
import notification from './modules/notification';

export default new Vuex.Store({
  modules: { auth, notification }
});