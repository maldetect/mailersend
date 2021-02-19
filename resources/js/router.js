import Vue from 'vue'
import Router from 'vue-router'
import List from './pages/List'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'list',
      component: List
    },
  ]
})

export default router;
