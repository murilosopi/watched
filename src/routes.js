import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);


import Home from '@/pages/Home';
import Login from '@/pages/Login';
import SignUp from '@/pages/SignUp';
import Search from '@/pages/Search';
import Profile from '@/pages/Profile';
import Movie from '@/pages/Movie';

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      component: Home,
    },
    {
      path: '/login',
      component: Login
    },
    {
      path: '/cadastro',
      component: SignUp
    },
    {
      path: '/pesquisar',
      component: Search
    },
    {
      path: '/usuario/:username',
      props: true,
      component: Profile
    },
    {
      path: '/filme/:id',
      props: true,
      component: Movie
    },
  ]
});