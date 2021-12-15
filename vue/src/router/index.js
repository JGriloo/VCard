import { createRouter, createWebHashHistory } from 'vue-router'
import CreateVCard from '../components/vcards/CreateVCard.vue'
import CreateCategory from '../components/categories/CreateCategory.vue'
import Home from '../views/Home.vue'
import Login from '../components/auth/Login.vue'
import VCard from '../components/vcards/VCard.vue'
import Transaction from '../components/transactions/Transaction.vue'
import Saving from '../components/transactions/Saving.vue'
import Categories from '../components/categories/Categories.vue'
import UserCategories from '../components/categories/UserCategories.vue'
import TransactionHistory from '../components/transactions/TransactionHistory.vue'
import EditDefaultCategory from '../components/categories/EditDefaultCategory.vue'
import EditCategory from '../components/categories/EditCategory.vue'
import EditTransaction from '../components/transactions/EditTransaction.vue'
import NotFound from '../views/NotFound.vue'
import AdminLogin from '../components/auth/AdminLogin.vue'
import VCardProfile from '../components/vcards/VCardProfile.vue'
import ChangePassword from "../components/auth/ChangePassword.vue"
import ChangeCode from "../components/auth/ChangeCode.vue"


const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/createvcard',
    name: 'Create',
    component: CreateVCard
  },
  {
    path: '/vcards/:phone_number/password',
    name: 'ChangePassword',
    component: ChangePassword,
    props: route => ({ phone_number: parseInt(route.params.phone_number) })

  },
  {
    path: '/savings',
    name: 'Savings',
    component: Saving,
    meta: { requiresAuth: true }
  },
  {
    path: '/code',
    name: 'ChangeCode',
    component: ChangeCode
  },
  {
    path: '/adminlogin',
    name: 'AdminLogin',
    component: AdminLogin
  },
  {
    path: '/vcards/:phone_number',
    name: 'VCard',
    component: VCard,
    props: route => ({ phone_number: parseInt(route.params.phone_number) })
  },
  {
    path: '/vcard/:phone_number',
    name: 'VCardProfile',
    component: VCardProfile,
    props: route => ({ phone_number: parseInt(route.params.phone_number) })
  },
  {
    path: '/vcards/edit/:phone_number',
    name: 'VCardDetails',
    component: VCard,
    props: route => ({ phone_number: parseInt(route.params.phone_number) })
  },
  {
    path: '/transactions',
    name: 'Transactions',
    component: Transaction,
    meta: { requiresAuth: true }
  },
  {
    path: '/savings',
    name: 'Savings',
    component: Saving,
    meta: { requiresAuth: true }
  },
  {
    path: '/mytransactions',
    name: 'MyTransactions',
    component: TransactionHistory
  },
  {
    path: '/transactions/edit/:id',
    name: 'EditTransaction',
    component: EditTransaction,
    props: route => ({ id: parseInt(route.params.id) })
  },
  {
    path: '/createcategory',
    name: 'CreateCategory',
    component: CreateCategory
  },
  {
    path: '/categories',
    name: 'Categories',
    component: Categories
  },
  {
    path: '/defaultcategories/edit/:id',
    name: 'EditDefaultCategory',
    component: EditDefaultCategory,
    props: route => ({ id: parseInt(route.params.id) })
  },
  {
    path: '/mycategories/edit/:id',
    name: 'EditCategory',
    component: EditCategory,
    props: route => ({ id: parseInt(route.params.id) })
  },
  { path: '/myCategories', name: 'MyCategories', component: UserCategories },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/:catchAll(.*)',
    name: 'NotFound',
    component: NotFound
  }
]

const router = createRouter({
  history: createWebHashHistory(process.env.BASE_URL),
  routes
})

export default router