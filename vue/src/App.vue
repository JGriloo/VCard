<template>
  <div id="nav">
    <router-link :to="{name: 'Home'}">Home </router-link>
    <router-link  :to="{name: 'Create'}">Create VCard </router-link>
    <router-link :to="{name: 'Transactions'}">Transactions</router-link>
    <router-link  :class="{activ: $router.name=='Login'}"  :to="{name: 'Login'}">Login</router-link>
    <!-- <router-link :to="{name: 'TransactionsHistory'}" >Transaction History</router-link> -->
    <!-- <router-link  :to="{name: 'Logout'}">Logout</router-link> -->
    <router-view/>
  </div>
</template>



<script>
export default {
  name: 'RootComponent',
  data () {
    return {
      
    }
  },
    methods: { 
    logout () { 
      this.$axios.post('logout') 
        .then(() => { 
          this.$toast.success('User has logged out of the application.') 
          delete this.$axios.defaults.headers.common.Authorization
          this.$store.commit('resetUser') 
          this.$router.push({ name: 'Home' })
        }) 
        .catch(() => { 
          this.$toast.error('There was a problem logging out of the application!') 
        }) 
    } 
  },
  mounted () {
    const token = sessionStorage.getItem('token')
    if (token) {
      this.$axios.defaults.headers.common.Authorization = "Bearer" + token;
      this.$store.dispatch('loadUser')
    }
    // this.$axios.get('users/' + this.userId + '/projects/inprogress')
    //   .then((response) => {
    //     this.workInProgressProjects = response.data.data
    //   })
    //   .catch((error) => {
    //     console.log(error)
    //   })
  },
  computed:{
        user () { 
      return this.$store.state.user 
    }, 
    userId () { 
      return this.$store.state.user ? this.$store.state.user.id : -1 
    }, 
    userName () { 
      return this.$store.state.user ? this.$store.state.user.name : '' 
    }, 
    userPhotoUrl () { 
      let urlPhoto = this.$store.state.user 
        ? this.$store.state.user.photo_url 
        : null 
      return urlPhoto 
        ? this.$serverUrl + '/storage/fotos/' + urlPhoto 
        : 'img/avatar-none.png' 
    } 
  }
}
</script>

<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>
