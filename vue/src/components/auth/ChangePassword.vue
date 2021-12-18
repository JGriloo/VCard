<template>
  <form
    class="row g-3 needs-validation"
    novalidate
  >
    <h3 class="mt-5 mb-3">Change Password</h3>
    <hr>
    <div class="mb-3">
      <div class="mb-3">
        <label
          for="inputCurrentPassword"
          class="form-label"
        >Current Password</label>
        <input
          type="password"
          class="form-control"
          id="inputCurrentPassword"
          required
          v-model="passwords.current_password"
        >
      </div>
    </div>
    <div class="mb-3">
      <div class="mb-3">
        <label
          for="inputPassword"
          class="form-label"
        >New Password</label>
        <input
          type="password"
          class="form-control"
          id="inputPassword"
          required
          v-model="passwords.password"
        >
      </div>
    </div>
    <div class="mb-3">
      <div class="mb-3">
        <label
          for="inputPasswordConfirm"
          class="form-label"
        >Password Confirmation</label>
        <input
          type="password"
          class="form-control"
          id="inputPasswordConfirm"
          required
          v-model="passwords.password_confirmation"
        >
      </div>
    </div>
    <div class="mb-3 d-flex justify-content-center">
      <button
        type="button"
        class="btn btn-primary px-5"
        @click.prevent="changePassword"
        style="background-color: green;"
      >Save</button>
      <button style="background-color: red;" @click="$router.back()">
        Cancel
      </button>
    </div>
  </form>
</template>

<script>
export default {
  name: 'ChangePassword',
  props: {
    phone_number: {
      type: Number,
      default: null
    }
  },
  data () {
    return {
      vcard: this.newVcard(),
      passwords: {
        current_password: '',
        password: '',
        password_confirmation: ''
      },
      errors: null,
      
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
  emits: [
    'changedPassword',
  ],
  methods: {
    dataAsString () {
      return JSON.stringify(this.vcard)
    },
    newVcard() {
      return {
        phone_number: null,
        name: '',
        email: '',
        photo_url: null
      }
    },
    loadVcard (phone_number) {
      this.errors = null
      if (!phone_number || (phone_number < 0)) {
        this.vcard = this.newVcard()
        this.originalValueStr = this.dataAsString()
      } else {
        this.$axios.get('vcards/' + phone_number)
          .then((response) => {
            this.vcard = response.data.data
            this.originalValueStr = this.dataAsString()
          })
          .catch((error) => {
            console.log(error)
          })
      }
    },
    changePassword () {
      this.errors = null
      this.$axios.post('vcards/' + this.phone_number + '/password', this.passwords)
        .then((response) => {
          this.$toast.success('Password alterada com sucesso.')
          this.vcard = response.data.data
          this.$emit('changedPassword')
          this.$store.commit('updateVcard', response.data.data)
          this.$router.push({name: 'VCardProfile'})
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.$toast.error('The password was not updated due to validation errors!')
            this.errors = error.response.data.errors
          } else {
            this.$toast.error('The password was not updated due to unknown server error!')
          }
        })
    },
  }
}
</script>

<style scoped>
</style>
