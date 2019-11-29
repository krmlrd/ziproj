import Vue from 'vue'
import VueRouter from 'vue-router'

import Login from '@/js/views/Login'
import Logout from '@/js/views/Logout'
import Register from '@/js/views/Register'
import Home from '@/js/components/Home'
import AdminDashboard from '@/js/views/admin/Dashboard'
import AdminHome from '@/js/views/admin/Home'
import AdminImages from '@/js/views/admin/Images'
import AdminPosts from '@/js/views/admin/Posts'

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
    meta: {
      requiresVisitor: true
    }
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: {
      requiresVisitor: true
    }
  },
  {
    path: '/logout',
    name: 'logout',
    component: Logout,
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/admin',
    name: 'dashboard',
    component: AdminDashboard,
    meta: {
      requiresAuth: true
    },
    children: [
      {
        path: '',
        component: AdminHome
      },
      {
        path: 'images',
        component: AdminImages
      },
      {
        path: 'posts',
        component: AdminPosts
      }
    ]
  },
]

export default routes
