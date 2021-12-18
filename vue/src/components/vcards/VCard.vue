<template>
  
  <VCardDetails
    :vcard="vcard"
    :errors="errors"
    @save="save"
    @cancel="cancel"
  ></VCardDetails>

</template>

<script>
/* eslint-disable vue/no-unused-components */
import VCardDetails from './VCardDetails.vue'

export default {
  name: 'VCard',
  components: {
    VCardDetails
  },
  props: {
    phone_number: {
      type: Number,
      default: null
    }
  },
  data() {
    return {
        vcard: this.newVcard(),
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
  methods: {
    dataAsString () {
      return JSON.stringify(this.vcard)
    },
    newVcard() {
      return {
        phone_number: null,
        name: '',
        email: '',
        max_debit: '',
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
            console.log(this.vcard)
            this.originalValueStr = this.dataAsString()
          })
          .catch((error) => {
            console.log(error)
          })
      }
    },
    save () {
      this.errors = null
      this.$axios.put('vcards/' + this.phone_number, this.vcard)
        .then((response) => {
          this.$toast.success('vCard #' + response.data.data.phone_number + ' was updated successfully.')
          this.vcard = response.data.data
          this.originalValueStr = this.dataAsString()
          this.$store.commit('updateVCard', response.data.data)
          this.$router.back();
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.$toast.error('vCard #' + this.phone_number + ' was not updated due to validation errors!')
            this.errors = error.response.data.errors
          } else {
            this.$toast.error('vCard #' + this.phone_number + ' was not updated due to unknown server error!')
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
  computed: {
     photoFullUrl () {
      return this.vcard.photo_url
        ? this.$serverUrl + "/storage/fotos/" + this.vcard.photo_url
        : "./assets/img/avatar-none.png"
    },
  }
}
</script>

<style scoped lang="scss">
.jumbotron {
  color: white;
  background-color: brown;
}

</style>
