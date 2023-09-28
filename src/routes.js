import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);
const header = () => import('@/components/PageHeader');

const Home = () => import('@/pages/home/Home');
const Login = () => import('@/pages/user/Login');
const SignUp = () => import('@/pages/user/SignUp');
const Search = () => import('@/pages/search/Search');
const Profile = () => import('@/pages/user/Profile');
const Movie = () => import('@/pages/movie/Movie');
const Error = () => import('@/pages/error/Error');
const Explore = () => import('@/pages/home/Explore.vue');


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