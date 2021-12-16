<template>
  <form class="row g-3 needs-validation" novalidate>
    <h3 class="mt-5 mb-3">Change Confirmation Code</h3>
    <hr />
    <div class="mb-3">
      <div class="mb-3">
        <label for="inputCurrentPassword" class="form-label"
          >Current Password</label
        >
        <input
          type="password"
          class="form-control"
          id="inputCurrentPassword"
          required
          v-model="codes.current_password"
        />
      </div>
    </div>
    <div class="mb-3">
      <div class="mb-3">
        <label for="inputCode" class="form-label">New Confirmation Code</label>
        <input
          type="code"
          class="form-control"
          id="inputCode"
          required
          v-model="codes.code"
        />
      </div>
    </div>
    <div class="mb-3">
      <div class="mb-3">
        <label for="inputCodeConfirm" class="form-label"
          >Code Confirmmation</label
        >
        <input
          type="code"
          class="form-control"
          id="inputCodeConfirm"
          required
          v-model="codes.code_confirm"
        />
      </div>
    </div>
    <div class="mb-3 d-flex justify-content-center">
      <button
        type="button"
        class="btn btn-primary px-5"
        @click.prevent="changeCode"
        style="background-color: green"
      >
        Change Confirmation Code
      </button>
      <button style="background-color: red" @click="$router.back()">
        Cancel
      </button>
    </div>
  </form>
</template>

<script>
export default {
  name: "ChangeCode",
  data() {
    return {
      codes: {
        current_password: "",
        code: "",
        code_confirm: "",
      },
      errors: null,
    };
  },
  emits: ["changedCode"],
  methods: {
    changeCode() {
      // FALTA FAZER O LOGIN
      this.$emit("changedCode");
    },
  },
};
</script>

<style scoped>
</style>
