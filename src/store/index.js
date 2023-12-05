import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import auth from './modules/auth';
import notification from './modules/notification';
import chat from './modules/chat';
import review from './modules/review';
import post from './modules/post';

export default new Vuex.Store({
  modules: { auth, notification, chat, review, post }
});