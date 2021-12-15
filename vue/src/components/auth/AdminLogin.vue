<template>
  <form class="row g-3 needs-validation" novalidate>
    <h3 class="mt-5 mb-3">Admin Login</h3>
    <hr />
    <div class="mb-3">
      <div class="mb-3">
        <label for="inputEmail" class="form-label">Email</label>
        <input
          type="email"
          name="email"
          class="form-control"
          id="inputEmail"
          placeholder="Email Address"
          required
          v-model="credentials.email"
        />
      </div>
    </div>
    <div class="mb-3">
      <div class="mb-3">
        <label for="inputPassword" class="form-label">Password</label>
        <input
          type="password"
          class="form-control"
          id="inputPassword"
          required
          v-model="credentials.password"
        />
      </div>
    </div>
    <div class="mb-3 d-flex justify-content-center">
      <button
        type="button"
        class="btn btn-primary px-5"
        @click.prevent="adminLogin"
      >
        Login
      </button>
    </div>
    <div class="mb-4 d-flex justify-content-center">
      <button @click="goToUserLogin()" style="background-color: grey">
        <i class="fas fa-arrow-circle-right"></i>
        VCard Login
      </button>
    </div>
  </form>
</template>

<script>
export default {
  name: "AdminLogin",
  data() {
    return {
      credentials: {
        email: "",
        password: "",
      },
      errors: null,
    };
  },
  emits: ["adminLogin"],
  methods: {
    adminLogin() {
      this.$store
        .dispatch("adminLogin", this.credentials)
        .then(() => {
          this.$toast.success(
            "Admin " +
              this.$store.state.user.name +
              " has entered the application."
          );
          this.$emit("adminLogin");
          this.$router.push({ name: "Home" });
        })
        .catch(() => {
          delete this.$axios.defaults.headers.common.Authorization;
          this.credentials.password = "";
          this.$store.commit("resetUser");
          this.$toast.error("User credentials are invalid!");
          console.log(this.credentials.username);
          console.log(this.credentials.password);
        });
    },
    goToUserLogin() {
      this.$router.push("/login");
    },
  },
};
</script>

<style scoped>
</style>
