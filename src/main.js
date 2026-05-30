import { createApp } from 'vue'
import {store} from './store'
import './style.css'
import './style-jobs.css'
import App from './App.vue'
import router from './router'
import vuetify from './vuetify/vuetify'
const app = createApp(App)
app.use(router)
app.use(store)
app.use(vuetify)
app.mount('#app')
