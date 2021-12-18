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
import Statistic from "../components/statistics/Statistic.vue"
import IndividualStatistic from "../components/statistics/IndividualStatistic.vue"
import CreateUser from "../components/users/CreateUser.vue"
import AdminDashboard from "../components/users/AdminDashboard.vue"
import User from "../components/users/User.vue"
import Users from "../components/users/Users.vue"
import VCards from "../components/users/VCards.vue"
import DefaultCategories from "../components/users/DefaultCategories.vue"
import AddCategory from "../components/users/AddCategory.vue"
import store from '../store'



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
    path: '/statistics',
    name: 'Statistics',
    component: Statistic,
    meta: { requiresAuth: true }
  },
  {
    path: '/mystatistics',
    name: 'IndividualStatistic',
    component: IndividualStatistic,
    meta: { requiresAuth: true }
  },
  {
    path: '/vcards/:phone_number/confirmationcode',
    name: 'ChangeCode',
    component: ChangeCode,
    props: route => ({ phone_number: parseInt(route.params.phone_number) }) 
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
  },
  {
    path: '/users/create',
    name: 'CreateUser',
    component: CreateUser
  },
  {
    path: '/users/:id',
    name: 'AdminDashboard',
    component: AdminDashboard,
    props: route => ({ id: parseInt(route.params.id) })
  },
  {
    path: '/users/:id',
    name: 'User',
    component: User,
    props: route => ({ id: parseInt(route.params.id) })
  },
  {
    path: '/users/edit/:id',
    name: 'UserDetails',
    component: User,
    props: route => ({ id: parseInt(route.params.id) })
  },
  {
    path: '/users',
    name: 'Users',
    component: Users,
  },
  {
    path: '/categories/default',
    name: 'DefaultCategories',
    component: DefaultCategories,
  },
  {
    path: '/categories/add',
    name: 'AddCategory',
    component: AddCategory,
  },
  {
    path: '/vcards',
    name: 'VCards',
    component: VCards,
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


router.beforeEach((to, from, next) => {
  if ((to.name == 'Login') || (to.name == 'AdminLogin') || (to.name == 'Home') || (to.name =='Create')) {
    next()
    return
  }
  if (!store.state.user) {
    next({ name: 'Login' })
    return
  }
  if (to.name == 'Users' || to.name == 'User' || to.name == 'AdminDashboard' || to.name == 'DefaultCategories' ||  to.name == 'AddCategory') {
    if ((store.state.user.type == 'A')) {
      next()
      return
    }
    next(false)
    return
  }
  next()
})

export default router