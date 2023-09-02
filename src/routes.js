import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);


import Home from '@/pages/home/Home';
import Login from '@/pages/user/Login';
import SignUp from '@/pages/user/SignUp';
import Search from '@/pages/search/Search';
import Profile from '@/pages/user/Profile';
import Movie from '@/pages/movie/Movie';

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