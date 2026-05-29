import about from "../components/About.vue";
import { store } from "../store/index.js";
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
  { path: "/", redirect: "/home" },
  { path: "/home", name: "home", component: Home },
  { path: "/FAQ", component: FAQ },
  { path: "/about", component: about },
  { path: '/signup', name:'signup', component: signUp },
  { path: '/login', name:'login', component: signUp },
  {
    path: "/jobs",
    name: "jobView",
    component: jobView,
    children: [
      { path: "", name: "jobBlank", component: jobBlank },

      { path: ":id", name: "jobDetail", component: JobDetail },
    ],
  },
  {
    path: "/admin",
    component: Admin,
    children: [{ path: ":id", component: JobApproveDetail }],
    meta: { requiresLogIn: true, role: 'admin' }
  },
];
const router = createRouter({
  history: createWebHashHistory(),
  routes,
});
export default router;

router.beforeEach((to, from, next) => {
  const isLoggedIn = store.getters.isLoggedIn;
  const userRole = store.getters.userRole;
  if (to.meta.requiresLogIn && !isLoggedIn) {
    next('/home')
    //next('/login')
  } else if (to.meta.role && userRole !== to.meta.role) {
    next('/home')
    //next('/unauthorised')
  } else {
    next()
  }
});
