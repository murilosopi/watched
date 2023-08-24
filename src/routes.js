import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);


import Home from '@/components/pages/Home';
import Login from '@/components/pages/Login';
import SignUp from '@/components/pages/SignUp';
import Search from '@/components/pages/Search';
import Profile from '@/components/pages/Profile';
import Movie from '@/components/pages/Movie';

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