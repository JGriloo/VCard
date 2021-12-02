import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'
import Toaster from "@meforma/vue-toaster"





let toastOptions = {
    position: 'top',
    timeout: 3000,
    pauseOnHover: true
}
const app = createApp(App).use(store).use(router).use(Toaster, toastOptions)

axios.defaults.baseURL="http://localhost/api/"
app.config.globalProperties.$axios = axios
app.config.globalProperties.$serverUrl = "http://localhost/"

app.mount('#app')
