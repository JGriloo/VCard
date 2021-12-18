<template>
  <form @submit.prevent="handleSubmit" method="post">
    <label style="color: black;">Name:</label>
    <input type="text" required v-model="name" />
    <label style="color: black;">Email:</label>
    <input type="email" required v-model="email" />
    <label style="color: black;">Password:</label>
    <input type="password" required v-model="password" />
    <div class="submit">
      <button>Submit</button>
    </div>
  </form>
</template>


<script>
export default {
  data() {
    return {
      name: "",
      email: "",
      password: "",
    };
  },
  methods: {
    handleSubmit() {
      this.$axios
        .post("/users/create", {
          name: this.name,
          email: this.email,
          password: this.password,
        })
        .then((result) => {
          this.$toast.success("User created successfully.")
          this.$router.push("/");
          console.warn(result);
        })
        .catch((error) => {
          console.log("ERRRR:: ", error.response.data);
        });
    },
  },
};
</script>

<style>
form {
  max-width: 420px;
  margin: 30px auto;
  background: white;
  text-align: left;
  padding: 40px;
  border-radius: 10px;
}
label {
  color: #aaa;
  display: inline-block;
  margin: 25px 0 15px;
  font-size: 0.6em;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-weight: bold;
}
input {
  display: block;
  padding: 10px 6px;
  width: 100%;
  box-sizing: border-box;
  border: none;
  border-bottom: 1px solid #ddd;
  color: #555;
}
button {
  background: #0b6dff;
  border: 0;
  padding: 10px 20px;
  margin-top: 20px;
  color: white;
  border-radius: 20px;
  cursor: pointer;
}
.submit {
  text-align: center;
}
.error {
  color: #ff0062;
  margin-top: 10px;
  font-size: 0.8em;
  font-weight: bold;
}

/* Chrome, Safari, Edge, Opera, remove number input arrows */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
/* Firefox  remove number input arrows */
input[type="number"] {
  -moz-appearance: textfield;
}
</style>