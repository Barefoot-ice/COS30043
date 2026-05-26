import { createRouter, createWebHashHistory } from 'vue-router'
import Home from '../components/Home.vue'
import FAQ from '../components/FAQ.vue'
import signUp from '../components/signUp.vue'
import jobListings from '../components/jobs/jobList.vue'
import JobDetail from '../components/jobs/jobDetail.vue'
import jobView from '../components/jobs/jobView.vue'
import jobBlank from '../components/jobs/jobBlank.vue'

const routes = [
{ path: '/', redirect: '/home' },
{ path: '/home', name:'home', component: Home},
{ path: '/FAQ', component: FAQ },
{ path: '/signup', component: signUp },

{ path: '/jobs', name: 'jobView', component: jobView,
    children: [
        {path: '', name: 'jobBlank', component: jobBlank},

        { path: ':id', name: 'jobDetail', component: JobDetail}
    ]
},
]
const router = createRouter({
history: createWebHashHistory(),
routes,
})
export default router