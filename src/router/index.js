import { createRouter, createWebHashHistory } from 'vue-router'
import Home from '../components/Home.vue'
import FAQ from '../components/FAQ.vue'
import signUp from '../components/signUp.vue'
const routes = [
{ path: '/', redirect: '/home' },
{ path: '/home', name:'home', component: Home},
{ path: '/FAQ', component: FAQ },
{ path: '/signup', component: signUp }
]
const router = createRouter({
history: createWebHashHistory(),
routes,
})
export default router