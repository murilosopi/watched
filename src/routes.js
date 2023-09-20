import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

import header from '@/components/PageHeader';

import Home from '@/pages/home/Home';
import Login from '@/pages/user/Login';
import SignUp from '@/pages/user/SignUp';
import Search from '@/pages/search/Search';
import Profile from '@/pages/user/Profile';
import Movie from '@/pages/movie/Movie';
import Error from '@/pages/error/Error';
import Explore from '@/pages/home/Explore.vue'

export default new Router({
  mode: 'history',

  scrollBehavior(to, from, savedPosition) {
    const defaultScroll = {x: 0, y: 0, behavior: 'instant'};

    if (savedPosition) {
      return savedPosition;
    } else {
      return defaultScroll;
    }
  },

  routes: [
    {
      path: '/',
      components: {
        header,
        page: Home,
      }
    },
    {
      path: '/explorar',
      components: {
        header,
        page: Explore,
      }
    },
    {
      path: '/login',
      components: {
        header,
        page: Login
      }
    },
    {
      path: '/cadastro',
      components: {
        header,
        page: SignUp
      }
    },
    {
      path: '/pesquisar',
      components: {
        header,
        page: Search
      }
    },
    {
      path: '/usuario/:username',
      props: {
        page: true,
        header: true
      },
      components: {
        header,
        page: Profile
      }
    },
    {
      path: '/filme/:id',
      props: {
        page: true,
        header: true
      },
      components: {
        header,
        page: Movie
      }
    },
    {
      path: '*',
      props:{
        header: {
          error: true
        }
      },
      components: {
        header,
        page: Error
      }
    },
  ]
});