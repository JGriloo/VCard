<template>
  <form
    v-if="this.$store.state.user.type == 'V'"
    class="row g-3 needs-validation"
    novalidate
    @submit.prevent="save"
  >
    <h3 class="mt-5 mb-3">vCard #{{ this.currentVcard.phone_number }}</h3>
    <hr />
    <div class="d-flex flex-wrap justify-content-between">
      <div class="w-75 pe-4">
        <div class="mb-3">
          <label for="inputName" class="form-label">Name</label>
          <input
            type="text"
            class="form-control"
            id="inputName"
            placeholder="vCard Name"
            required
            v-model="currentVcard.name"
          />
          <field-error-message
            :errors="errors"
            fieldName="name"
          ></field-error-message>
        </div>

        <div class="mb-3 px-1">
          <label for="inputEmail" class="form-label">Email</label>
          <input
            type="email"
            class="form-control"
            id="inputEmail"
            placeholder="Email"
            required
            v-model="currentVcard.email"
          />
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
            <img :src="photoFullUrl" class="w-100" />
          </div>
        </div>
      </div>
    </div>
    <div class="mb-3 d-flex justify-content-end">
      <button
        type="button"
        class="btn btn-primary px-5"
        style="background-color: green"
        @click="save"
      >
        Save
      </button>
      <button
        type="button"
        class="btn btn-light px-5"
        style="background-color: red"
        @click="cancel"
      >
        Cancel
      </button>
    </div>
  </form>

  <form
    v-if="this.$store.state.user.type == 'A'"
    class="row g-3 needs-validation"
    novalidate
    @submit.prevent="save"
  >
    <h3 class="mt-5 mb-3">vCard #{{ this.currentVcard.phone_number }}</h3>
    <hr />
    <div class="d-flex flex-wrap justify-content-between">
      <div class="w-75 pe-4">
        <div class="mb-3">
          <label for="inputDebit" class="form-label" style="color: black"
            >Max Debit</label
          >
          <input
            type="text"
            class="form-control"
            id="inputDebit"
            placeholder="VCard's Max Debit"
            required
            v-model="currentVcard.max_debit"
          />
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
        style="background-color: green"
        @click="save"
      >
        Save
      </button>
      <button
        type="button"
        class="btn btn-light px-5"
        style="background-color: red"
        @click="cancel"
      >
        Cancel
      </button>
    </div>
  </form>
</template>

<script>
export default {
  name: "VCardDetails",
  components: {},
  props: {
    vcard: {
      type: Object,
      required: true,
    },
    errors: {
      type: Object,
      default: null,
    },
  },
  emits: ["save", "cancel"],
  data() {
    return {
      currentVcard: this.vcard,
    };
  },
  watch: {
    vcard(newVcard) {
      this.currentVcard = newVcard;
    },
  },
  computed: {
    photoFullUrl() {
      return this.currentVcard.photo_url
        ? this.$serverUrl + "/storage/fotos/" + this.currentVcard.photo_url
        : "./assests/img/avatar-none.png";
    },
  },
  methods: {
    save() {
      this.$emit("save", this.currentVcard);
      this.$router.back();
    },
    cancel() {
      this.$emit("cancel", this.currentVcard);
    },
  },
};
</script>

<style scoped lang="scss">
</style>