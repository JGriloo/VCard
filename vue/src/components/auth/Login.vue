<<<<<<< HEAD
<template>
  <form class="row g-3 needs-validation" novalidate>
    <h3 class="mt-5 mb-3">Login</h3>
    <hr />
    <div class="mb-3">
      <div class="mb-3">
        <label for="inputUsername" class="form-label">Phone number</label>
        <input
          type="text"
          class="form-control"
          id="inputUsername"
          required
          v-model="credentials.username"
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
      <button type="button" class="btn btn-primary px-5" @click.prevent="login">
        Login
      </button>
    </div>
    <div class="mb-4 d-flex justify-content-center">
      <button
        type="button"
        class="btn btn-primary px-5"
        @click="goToAdminLogin()"
      >
        Admin Login
      </button>
    </div>
  </form>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      credentials: {
        username: "",
        password: "",
      },
      errors: null,
    };
  },
  emits: ["login"],
  methods: {
    login() {
      this.$store
        .dispatch("login", this.credentials)
        .then(() => {
          this.$toast.success(
            "User " +
              this.$store.state.user.name +
              " has entered the application."
          );
          this.$emit("login");
          console.log("emit login",this.$store.state.user)
          this.$socket.emit('login',this.$store.state.user)
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
    logout() {
      this.$axios
        .post("logout")
        .then(() => {
          this.$toast.success("User has logged out of the application.");
          delete this.$axios.defaults.headers.common.Authorization;
          this.$store.commit("resetUser");
          this.$router.push({ name: "Home" });
        })
        .catch(() => {
          this.$toast.error(
            "There was a problem logging out of the application!"
          );
        });
    },
    goToAdminLogin() {
      this.$router.push("/adminlogin");
    },
  },
};
</script>

<style scoped>
=======
<template>
  <form class="row g-3 needs-validation" novalidate>
    <h3 class="mt-5 mb-3">Login</h3>
    <hr />
    <div class="mb-3">
      <div class="mb-3">
        <label for="inputUsername" class="form-label">Phone number</label>
        <input
          type="text"
          class="form-control"
          id="inputUsername"
          required
          v-model="credentials.username"
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
      <button type="button" class="btn btn-primary px-5" @click.prevent="login">
        Login
      </button>
    </div>
    <div class="mb-4 d-flex justify-content-center">
      <button
        type="button"
        class="btn btn-primary px-5"
        @click="goToAdminLogin()"
      >
        Admin Login
      </button>
    </div>
  </form>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      credentials: {
        username: "",
        password: "",
      },
      errors: null,
    };
  },
  emits: ["login"],
  methods: {
    login() {
      this.$store
        .dispatch("login", this.credentials)
        .then(() => {
          this.$toast.success(
            "User " +
              this.$store.state.user.name +
              " has entered the application."
          );
          this.$emit("login");
          this.$router.push({ name: "Home" });
        })
        .catch(() => {
          console.log(this.credentials);
          console.log(this.credentials.password);
          delete this.$axios.defaults.headers.common.Authorization;
          this.credentials.password = "";
          this.$store.commit("resetUser");
          this.$toast.error("User credentials are invalid!");
          console.log(this.credentials.username);
          console.log(this.credentials.password);
        });
    },
    logout() {
      this.$axios
        .post("logout")
        .then(() => {
          this.$toast.success("User has logged out of the application.");
          delete this.$axios.defaults.headers.common.Authorization;
          this.$store.commit("resetUser");
          this.$router.push({ name: "Home" });
        })
        .catch(() => {
          this.$toast.error(
            "There was a problem logging out of the application!"
          );
        });
    },
    goToAdminLogin() {
      this.$router.push("/adminlogin");
    },
  },
};
</script>

<style scoped>
>>>>>>> 2b051026b75e280f09607fa3e9db532d3067424a
</style>