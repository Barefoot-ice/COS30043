import about from "../components/About.vue";
import { createRouter, createWebHashHistory } from "vue-router";
import Home from "../components/Home.vue";
import FAQ from "../components/FAQ.vue";
import signUp from "../components/signUp.vue";
import apply from "../components/apply.vue";
import jobListings from "../components/jobs/jobList.vue";
import JobDetail from "../components/jobs/jobDetail.vue";
import jobView from "../components/jobs/jobView.vue";
import jobBlank from "../components/jobs/jobBlank.vue";
import Admin from "../components/admin/admin.vue";
import JobApproveDetail from "../components/admin/jobApproveDetail.vue";

const routes = [
{ path: '/', redirect: '/home' },
{ path: '/home', name:'home', component: Home},
{ path: '/FAQ', component: FAQ },
{ path: '/signup', name:'signup', component: signUp },
{ path: '/login', name:'login', component: signUp },
{ path: '/apply/:id', name:'application', component: apply }
]
const router = createRouter({
  history: createWebHashHistory(),
  routes,
});
export default router;
