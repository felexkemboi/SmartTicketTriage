import { createRouter, createWebHistory } from 'vue-router'
import Home from './pages/Home.vue'
import Dashboard from './pages/Dashboard.vue'
import TopBar from './pages/nav/TopBar.vue';


const routes = [
  { path: '/home', component: Home },
  { path: '/dashboard', component: Dashboard },
  { path: '/',component: TopBar },
]

export default createRouter({
  history: createWebHistory(),
  routes,
})