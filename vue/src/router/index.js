
import { createRouter, createWebHashHistory } from 'vue-router'
import CreateVCard from '../views/Create.vue'
import Home from '../views/Home.vue'
import Login from '../components/auth/Login.vue'
import Transaction from '../views/Transactions.vue'
// import TransactionHistory from '../views/TransactionsHistory.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/create',
    name: 'Create',
    component: CreateVCard
  },
  {
    path: '/transactions',
    name:'Transactions',
    component: Transaction
  },
  {
  path: '/login',
  name: 'Login',
  component: Login
  },
  // {
  //   path: '/transactionshistory',
  //   name: 'TransactionHistory',
  //   component: TransactionHistory
  // }
  // {
  //   path:'/logout',
  //   name:'Logout',
  //   component
  // }


]

const router = createRouter({
  history: createWebHashHistory(process.env.BASE_URL),
  routes
})

export default router
