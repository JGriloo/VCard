<template>
  <form
    class="row g-3 needs-validation"
    novalidate
  >
    <h3 class="mt-5 mb-3">Change Confirmation Code</h3>
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
          v-model="codes.current_password"
        >
      </div>
    </div>
    <div class="mb-3">
      <div class="mb-3">
        <label
          for="inputCode"
          class="form-label"
        >New Confirmation Code</label>
        <input
          type="code"
          class="form-control"
          id="inputCode"
          required
          v-model="codes.confirmation_code"
        >
      </div>
    </div>
    <div class="mb-3">
      <div class="mb-3">
        <label
          for="inputCodeConfirm"
          class="form-label"
        >Code Confirmmation</label>
        <input
          type="code"
          class="form-control"
          id="inputCodeConfirm"
          required
          v-model="codes.confirmation_code_confirmation"
        >
      </div>
    </div>
    <div class="mb-3 d-flex justify-content-center">
      <button
        type="button"
        class="btn btn-primary px-5"
        @click.prevent="changeCode"
        style="background-color: green;"
      >Change Confirmation Code</button>
      <button style="background-color: red;" @click="$router.back()">
        Cancel
      </button>
    </div>
  </form>
</template>

<script>
export default {
  name: 'ChangeCode',
  props: {
    phone_number: {
      type: Number,
      default: null
    }
  },
  data () {
    return {
      vcard: this.newVcard(),
      codes: {
        current_password: '',
        confirmation_code: '',
        confirmation_code_confirmation: ''
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
    'changedCode',
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
    changeCode () {
      this.errors = null
      this.$axios.post('vcards/' + this.phone_number + '/confirmationcode', this.codes)
        .then((response) => {
          this.$toast.success('Confirmation code alterado com sucesso.')
          this.vcard = response.data.data
          this.$emit('changedCode')
          this.$store.commit('updateVcard', response.data.data)
          this.$router.push({name: 'vCardProfile'})
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.$toast.error('The code was not updated due to validation errors!')
            this.errors = error.response.data.errors
          } else {
            this.$toast.error('The code was not updated due to unknown server error!')
          }
        })
    },
  }
}
</script>

<style scoped>
</style>
