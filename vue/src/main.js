import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'
import Toaster from "@meforma/vue-toaster"
import FieldErrorMessage from "./components/global/FieldErrorMessage.vue"
import ConfirmationDialog from "./components/global/ConfirmationDialog.vue"
import '@fortawesome/fontawesome-free/js/all'
import VueSocketIO from 'vue-3-socket.io'

let toastOptions = {
  position: 'top',
  timeout: 3000,
  pauseOnHover: true
}
const socketIO = new VueSocketIO({
  debug: true,
  connection: 'http://localhost:8080',
  vuex: {
    store,
    actionPrefix: 'SOCKET_',
    mutationPrefix: 'SOCKET_'
  }
})

/* const loggedIn = {
  data: {
    access_token: null,
    currentUser: null,
  },
  computed: {
    loggedIn() {
      return this.$root.$data.access_token != null;
    }
  }
} */

const app = createApp(App).use(store).use(router).use(Toaster, toastOptions).use(socketIO)

store.$toast = app.$toast
store.$socket = socketIO.io

axios.defaults.baseURL = "http://localhost/api"
app.config.globalProperties.$axios = axios
app.config.globalProperties.$serverUrl = "http://localhost/"

app.component('field-error-message', FieldErrorMessage)
app.component('confirmation-dialog', ConfirmationDialog)

app.mount('#app')