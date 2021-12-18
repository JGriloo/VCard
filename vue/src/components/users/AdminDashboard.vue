<template>
<div>
    <div class="mt-5 mb-3" style="background-color: darkblue; color: white;">PROFILE</div>
    <hr>
        <h2> User # {{ user.id }}</h2>
        <h2> Name: {{ user.name }}</h2>
        <h2> Email: {{ user.email }}</h2>
        <button @click="goToEditProfile()" style="position: absolute; left: 200px; top: 200px; background-color: orange; "><i class="fas fa-exchange-alt"></i> Edit Profile</button>
    <hr>
    <div>
        <button @click="goToChangePassword()" style="position: absolute; left: 200px; top: 250px; background-color: grey;"><i class="fas fa-key"></i> Change Password</button>
    </div>
</div>
</template>

<script>
export default {
    name: 'userProfile',
    props: {
    id: {
      type: Number,
      default: null
      }
     },
    data () {
        return {
        user: null,
        }
    },
    watch: {
    id: {
      immediate: true,
      handler (newValue) {
        this.loadUser(newValue)
      }
    }
  },
    methods: {
        dataAsString () {
      return JSON.stringify(this.user)
    },
        loadUser (id) {
        this.$axios.get('users/' + id)
          .then((response) => {
            this.user = response.data.data
            console.log(this.user)
            this.originalValueStr = this.dataAsString()
          })
          .catch((error) => {
            console.log(error)
          })
        },
        goToChangePassword () {
          this.$router.push('/users/' + this.user.id + '/password'); 
        },
        goToEditProfile () {
          this.$router.push({name: 'UserDetails'});
        }
    },
    computed: {
          
    }
}
</script>