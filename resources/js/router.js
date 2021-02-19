import Vue from 'vue'
import Router from 'vue-router'
import Send from './pages/Send'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  routes: [
    {
      path: '/teste',
      name: 'send',
      component: Send
    },
  ]
})

export default router;
