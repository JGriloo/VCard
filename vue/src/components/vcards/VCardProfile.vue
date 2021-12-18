<template>
  <div>
    <div class="mt-5 mb-3" style="background-color: darkblue; color: white">
      PROFILE
    </div>
    <hr />
    <h2>vCard # {{ vcard.phone_number }}</h2>
    <h2>Name: {{ vcard.name }}</h2>
    <h2>Email: {{ vcard.email }}</h2>
    <div class="mb-3">
      <h3>Photo</h3>
      <div class="form-control text-center">
        <img :src="photoFullUrl" class="w-100" />
      </div>
    </div>
    <hr />
    <h2>Balance: {{ vcard.balance }} €</h2>
    <div>
      <button
        @click="goToChangePassword()"
        style="
          position: absolute;
          left: 200px;
          text-decoration: none;
          background-color: orange;
        "
      >
        <i class="fas fa-key"></i> Change Password
      </button>
      <button
        @click="goToChangeCode()"
        style="
          position: absolute;
          left: 200px;
          top: 490px;
          text-decoration: none;
          background-color: orange;
        "
      >
        <i class="fas fa-key"></i> Change Confirmation Code
      </button>
    </div>
  </div>
</template>

<script>
export default {
    name: 'CardProfile',
    props: {
    phone_number: {
      type: Number,
      default: null
      }
     },
    data () {
        return {
        vcard: null,
        }
    },
    watch: {
    phone_number: {
      immediate: true,
      handler (newValue) {
        this.loadVcard(newValue)
      }
    }
  },
    methods: {
        dataAsString () {
      return JSON.stringify(this.vcard)
    },
      loadVcard (phone_number) {
                setTimeout(() => {
        this.$axios.get('vcards/' + phone_number)
          .then((response) => {
            this.vcard = response.data.data
            console.log(this.vcard)
            this.originalValueStr = this.dataAsString()
          })
          .catch((error) => {
            console.log(error)
          })
        },3000)},


        goToChangePassword () {
          this.$router.push('/vcards/' + this.vcard.phone_number + '/password'); 
        },
        goToChangeCode () {
          this.$router.push('/vcards/' + this.vcard.phone_number + '/confirmationcode');
        }
    },
    computed: {
     photoFullUrl () {
      return this.$store.state.user.photo_url
        ? this.$serverUrl + "/storage/fotos/" + this.$store.state.user.photo_url
        : "./assets/img/avatar-none.png"
    },
    isLoggedIn(){
    return this.$store.getters.isLoggedIn
    },
  }
}
</script>