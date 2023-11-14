import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import auth from './modules/auth';
import notification from './modules/notification';
import chat from './modules/chat';

export default new Vuex.Store({
  modules: { auth, notification, chat }
});