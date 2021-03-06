<template>
  <confirmation-dialog
    ref="confirmationDialog"
    confirmationBtn="Discard changes and leave"
    msg="Do you really want to leave? You have unsaved changes!"
    @confirmed="leaveConfirmed"
  >
  </confirmation-dialog>
  <user-details
    :user="user"
    :errors="errors"
    @save="save"
    @cancel="cancel"
  ></user-details>
</template>

<script>
import UserDetails from "./UserDetails.vue"

export default {
  name: 'User',
  components: {
    UserDetails
  },
  props: {
    id: {
      type: Number,
      default: null
    },
  },
  data () {
    return {
      user: this.newUser(),
      errors: null,
    }
  },
  watch: {
    // beforeRouteUpdate was not fired correctly
    // Used this watcher instead to update the ID
    id: {
      immediate: true,
      handler (newValue) {
        this.loadUser(newValue)
      }
    },
  },
  methods: {
    dataAsString () {
      return JSON.stringify(this.user)
    },
    newUser () {
      return {
        id: null,
        name: '',
        email: '',
      }
    },
    loadUser (id) {
      this.errors = null
      if (!id || (id < 0)) {
        this.user = this.newUser()
        this.originalValueStr = this.dataAsString()
      } else {
        this.$axios.get('users/' + id)
          .then((response) => {
            this.user = response.data.data
            this.originalValueStr = this.dataAsString()
          })
          .catch((error) => {
            console.log(error)
          })
      }
    },
    save () {
      this.errors = null
      this.$axios.put('users/' + this.id, this.user)
        .then((response) => {
          this.$toast.success('User #' + response.data.data.id + ' was updated successfully.')
          this.user = response.data.data
          this.originalValueStr = this.dataAsString()
          this.$router.back()
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.$toast.error('User #' + this.id + ' was not updated due to validation errors!')
            this.errors = error.response.data.errors
          } else {
            this.$toast.error('User #' + this.id + ' was not updated due to unknown server error!')
          }
        })
    },
    cancel () {
      // Replace this code to navigate back
      // this.loadUser(this.id)
      this.$router.back()
    },
    leaveConfirmed () {
      if (this.nextCallBack) {
        this.nextCallBack()
      }
    }
  },
  beforeRouteLeave (to, from, next) {
    this.nextCallBack = null
    let newValueStr = this.dataAsString()
    if (this.originalValueStr != newValueStr) {
      this.nextCallBack = next
      let dlg = this.$refs.confirmationDialog
      dlg.show()
    } else {
      next()
    }
  }
}
</script>
