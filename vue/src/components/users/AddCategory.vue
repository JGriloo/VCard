<template>
  <form v-if="this.$store.state.user.type == 'V'"
    class="row g-3 needs-validation"
    novalidate
    @submit.prevent="save"
  >
    <h3 class="mt-5 mb-3">vCard #{{ this.currentVcard.phone_number }}</h3>
    <hr>
    <div class="d-flex flex-wrap justify-content-between">
      <div class="w-75 pe-4">
        <div class="mb-3">
          <label
            for="inputName"
            class="form-label"
          >Name</label>
          <input
            type="text"
            class="form-control"
            id="inputName"
            placeholder="vCard Name"
            required
            v-model="currentVcard.name"
          >
          <field-error-message
            :errors="errors"
            fieldName="name"
          ></field-error-message>
        </div>

        <div class="mb-3 px-1">
          <label
            for="inputEmail"
            class="form-label"
          >Email</label>
          <input
            type="email"
            class="form-control"
            id="inputEmail"
            placeholder="Email"
            required
            v-model="currentVcard.email"
          >
          <field-error-message
            :errors="errors"
            fieldName="email"
          ></field-error-message>
        </div>
      </div>
      <div class="w-25">
        <div class="mb-3">
          <label class="form-label">Photo</label>
          <div class="form-control text-center">
            <img
              :src="photoFullUrl"
              class="w-100"
            >
          </div>
        </div>
      </div>
    </div>
    <div class="mb-3 d-flex justify-content-end">
      <button
        type="button"
        class="btn btn-primary px-5"
        style="background-color: green;"
        @click="save"
      >Save</button>
      <button
        type="button"
        class="btn btn-light px-5"
        style="background-color: red;"
        @click="cancel"
      >Cancel</button>
    </div>

  </form>

  <form v-if="this.$store.state.user.type == 'A'"
    class="row g-3 needs-validation"
    novalidate
    @submit.prevent="save"
  >
    <h3 class="mt-5 mb-3">Add Category</h3>
    <hr>
    <div class="d-flex flex-wrap justify-content-between">
      <div class="w-75 pe-4">
        <div class="mb-3">
                <label
                    for="inputType"
                    class="form-label"
                    style="color: black; font-size: 0.8em;"
                >Type:</label>
                <input
                    type="text"
                    class="form-control"
                    id="inputType"
                    placeholder="Category's Type (C or D)"
                    required
                    v-model="category.type"
                >
                <label
                    for="inputName"
                    class="form-label"
                    style="color: black; font-size: 0.8em;"
                >Name:</label>
                <input
                    type="text"
                    class="form-control"
                    id="inputName"
                    placeholder="Category's Name"
                    required
                    v-model="category.name"
                >
          <field-error-message
            :errors="errors"
            fieldName="name"
          ></field-error-message>
        </div>
      </div>
    </div>
    <div class="mb-3 d-flex justify-content-end">
      <button
        type="button"
        class="btn btn-primary px-5"
        style="background-color: green;"
        @click="save"
      >Save</button>
      <button
        type="button"
        class="btn btn-light px-5"
        style="background-color: red;"
        @click="cancel"
      >Cancel</button>
    </div>

  </form>

</template>

<script>

export default {
  name: 'AddCategory',
  components: {
    
  },
  emits: [
    'save',
    'cancel'
  ],
  data() {
    return {
        category: {
            type: this.type,
            name: this.name
        },
        errors: null
    }
  },
    methods: {
  save() {
    this.errors = null
    this.$axios.post('categories/default', this.category)
    .then(() => {
        this.$toast.success('Category was added successfully.')
        this.$router.back()
        })
        .catch((error) => {
        if (error.response.status == 422) {
            this.$toast.error('Category was not added due to validation errors!')
            this.errors = error.response.data.errors
        } else {
            this.$toast.error('Category was not added due to unknown server error!')
        }
        })
  },
  cancel () {
    this.$router.back()
  }
}
}  



</script>

<style scoped lang="scss">
</style>