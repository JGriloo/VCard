<template>
  <form class="row g-3 needs-validation" novalidate @submit.prevent="save">
    <h3 class="mt-5 mb-3">VCard #{{ this.currentVCard.phone_number }}</h3>
    <hr />
    <div class="d-flex flex-wrap justify-content-between">
      <div class="w-75 pe-4">
        <div class="mb-3">
          <label for="inputName" class="form-label">Name</label>
          <input
            type="text"
            class="form-control"
            id="inputName"
            placeholder="VCard Name"
            required
            v-model="currentVCard.name"
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
            v-model="currentVCard.email"
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
      <button type="button" class="btn btn-primary px-5" @click="save">
        Save
      </button>
      <button type="button" class="btn btn-light px-5" @click="cancel">
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
      currentVCard: this.vcard,
    };
  },
  watch: {
    vcard(newVCard) {
      this.currentVCard = newVCard;
    },
  },
  computed: {
    photoFullUrl() {
      return this.currentVCard.photo_url
        ? this.$serverUrl + "/storage/fotos/" + this.currentVCard.photo_url
        : "./assests/img/avatar-none.png";
    },
  },
  methods: {
    save() {
      this.$emit("save", this.currentVCard);
    },
    cancel() {
      this.$emit("cancel", this.currentVCard);
    },
  },
};
</script>

<style scoped lang="scss">
</style>