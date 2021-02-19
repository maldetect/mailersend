import Vue from 'vue'
import Vuetify from 'vuetify'
import "../sass/app.scss";
import App from './pages/App'
import Router from 'vue-router'
import Send from './pages/Send'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'send',
      component: Send
    },
  ]
})


Vue.use(Vuetify)


const app = new Vue({
    el: '#app',
    components: { App },
    router,
    vuetify: new Vuetify({
       icons: {
         iconfont: 'md',  // 'mdi' || 'mdiSvg' || 'md' || 'fa' || 'fa4'
       },
       theme: {
         themes: {
           light: {
             //primary: '#4A8EAF',
             primary:'#121926',
             secondary: '#b0bec5',
             accent: '#8c9eff',
             indigo: '#4A8EAF',
           },
         },
       },
     })
   });
window.app =app
